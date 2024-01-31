@php
    if($tipo === 'in')
        $color = 'success';
    elseif($tipo === 'out')
        $color = 'danger';
    else
        $color = 'primary';
@endphp
<x-offcanvas id="offcanvas" title="Filtro de transações" direction="end" class="rounded-start-5">
    <form id="form-filter" action="#">
        <div class="card-body">
            <div class="mb-5">
                <div class="row">
                    <div class="col">
                        <label class="form-label">De</label>
                        <input type="date" class="input-highlight {{$color}} text-{{$color}}" name="start_date">
                    </div>
                    <div class="col">
                        <label class="form-label">Até</label>
                        <input type="date" class="input-highlight {{$color}} text-{{$color}}" name="end_date">
                    </div>
                </div>
            </div>
            <div class="input-icon mb-5" wire:ignore>
                <label class="form-label text-muted">Categoría</label>
                <select class="form-select input-highlight select-ignore" id="select-categorias-filter" multiple
                        name="categorias_id">
                    @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}"
                                data-custom-properties="&lt;div class=&quot;badge bg-{{$categoria->cor}} badge-pill me-2&quot;&gt;&lt;i class=&quot;icon text-md {{$categoria->icone}}&quot;&gt;&lt;/i&gt;&lt;/div&gt;">
                            {{$categoria->nome}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-icon mb-5" wire:ignore>
                <label class="form-label text-muted">Situação</label>
                <select class="form-select input-highlight" name="situacao">
                    <option value="">Todas</option>
                    <option value="pg">Pagas</option>
                    <option value="pe">Pendentes</option>
                </select>
            </div>
            <div class="input-icon mb-5" wire:ignore>
                <label class="form-label text-muted">Recorrência</label>
                <select class="form-select input-highlight" name="recorrencia">
                    <option value="">Todas</option>
                    <option value="rr">Sim</option>
                    <option value="n/a">Não</option>
                </select>
            </div>
            @if($tipo === null)
                <div class="input-icon mb-5" wire:ignore>
                    <label class="form-label text-muted">Tipo</label>
                    <select class="form-select input-highlight" name="tipo">
                        <option value="">Todas</option>
                        <option value="in">Receitas</option>
                        <option value="out">Despesas</option>
                    </select>
                </div>
            @endif
        </div>
    </form>
    <div class="btn-list mb-5">
        <button data-bs-dismiss="offcanvas" class="btn btn-outline-{{$color}} rounded-5 w-25">Cancelar</button>
        <button id="btn-submit" data-bs-dismiss="offcanvas" class="btn btn-{{$color}} ms-auto rounded-5 w-25">
            Aplicar
        </button>
    </div>
</x-offcanvas>

<script>
    $(document).ready(function () {
        const selectCategoriasFilter = document.getElementById('select-categorias-filter');

        if (selectCategoriasFilter) {
            new TomSelect(selectCategoriasFilter, {
                plugins: {
                    remove_button: {
                        title: 'Remover',
                    },
                },
                focus: false,
                copyClassesToDropdown: false,
                dropdownParent: selectCategoriasFilter.parentNode,
                controlInput: '<input>',
                render: {
                    item: function (data, escape) {
                        if (data.customProperties) {
                            return '<div class="rounded-5 text-sm bg-body"><span>' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            });
        }

        $('#btn-submit').click(function () {
            let formData = $('#form-filter').serializeArray();
            let data = {};
            $.each(formData, function (index, field) {
                if (field.name === 'categorias_id') {
                    if (data[field.name]) {
                        data[field.name].push(field.value);
                    } else {
                        data[field.name] = [field.value];
                    }
                } else {
                    data[field.name] = field.value;
                }
            });
            Livewire.emit('applyFilter', data);
        });
    });
</script>
