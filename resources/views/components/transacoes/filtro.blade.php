@php
    if($tipo === 'in')
        $color = 'success';
    elseif($tipo === 'out')
        $color = 'danger';
    else
        $color = 'primary';
@endphp
<x-offcanvas id="offcanvas" title="Filtro de transações" direction="end" class="rounded-start-5">
    <div class="card-body">
        <div class="mb-5">
            <div class="row">
                <div class="col">
                    <label class="form-label">De</label>
                    <input type="date" class="input-highlight {{$color}} text-{{$color}}"
                           wire:model.defer="startDateFilter">
                </div>
                <div class="col">
                    <label class="form-label">Até</label>
                    <input type="date" class="input-highlight {{$color}} text-{{$color}}"
                           wire:model.defer="endDateFilter">
                </div>
            </div>
        </div>
        <div class="input-icon mb-5" wire:ignore>
            <label class="form-label text-muted">Categoría</label>
            <select class="form-select input-highlight select-ignore" id="select-categorias-filter" multiple
                    wire:model.defer="categoriasIdFilter">
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
            <select class="form-select input-highlight"
                    wire:model.defer="situacaoFilter">
                <option value="">Todas</option>
                <option value="pg">Pagas</option>
                <option value="pe">Pendentes</option>
            </select>
        </div>
        <div class="input-icon mb-5" wire:ignore>
            <label class="form-label text-muted">Recorrência</label>
            <select class="form-select input-highlight"
                    wire:model.defer="recorrenciaFilter">
                <option value="">Todas</option>
                <option value="n/a">Não</option>
                <option value="rr">Recorrentes</option>
                <option value="fx">Fixas</option>
            </select>
        </div>
        @if($tipo === null)
            <div class="input-icon mb-5" wire:ignore>
                <label class="form-label text-muted">Tipo</label>
                <select class="form-select input-highlight"
                        wire:model.defer="tipoFilter">
                    <option value="">Todas</option>
                    <option value="in">Receitas</option>
                    <option value="out">Despesas</option>
                </select>
            </div>
        @endif
    </div>
    <div class="btn-list mx-5 mb-5">
        <button data-bs-dismiss="offcanvas" class="btn btn-outline-{{$color}} rounded-5 w-25">Cancelar</button>
        <button data-bs-dismiss="offcanvas" wire:click="applyFilter" class="btn btn-{{$color}} ms-auto rounded-5 w-25">Aplicar</button>
    </div>
</x-offcanvas>

<script>
    $(document).ready(function () {
        let el;
        window.TomSelect && (new TomSelect(el = document.getElementById('select-categorias-filter'), {
            plugins: {
                remove_button: {
                    title: 'Remover',
                },
            },
            focus: false,
            copyClassesToDropdown: false,
            dropdownParent: el.parentNode,
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
        }));
    });
</script>
