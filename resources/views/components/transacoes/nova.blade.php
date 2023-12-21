@php
    if(!$color)
        $color = $tipo === 'in' ? 'success' : 'danger';
    $transacaoTipo = $color === 'success' ? 'receita' : 'despesa';
    $acao = $creating ? 'Nova' : 'Editar';
    $method = $creating ? 'create' : 'update';
@endphp
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

<div wire:ignore.self class="modal modal-blur fade" id="nova-transacao-modal" tabindex="-1" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-5">
            <div class="modal-header border-0">
                <h2 class="text-{{$color}} text-capitalize fw-bolder">{{$acao}} {{$transacaoTipo}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <div class="mb-3 @if($recorrenteOpcao === 'all') d-none @endif">
                    <label class="form-label text-muted">Valor</label>
                    <div class="input-icon">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calculator me-2"
                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                              d="M0 0h24v24H0z"
                                                                                              fill="none"/><path
                                d="M4 3m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/><path
                                d="M8 7m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z"/><path
                                d="M8 14l0 .01"/><path d="M12 14l0 .01"/><path d="M16 14l0 .01"/><path d="M8 17l0 .01"/><path
                                d="M12 17l0 .01"/><path d="M16 17l0 .01"/></svg>
                       <svg xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-currency-real text-{{$color}}"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M21 6h-4a3 3 0 0 0 0 6h1a3 3 0 0 1 0 6h-4"/>
                            <path d="M4 18v-12h3a3 3 0 1 1 0 6h-3c5.5 0 5 4 6 6"/>
                            <path d="M18 6v-2"/>
                            <path d="M17 20v-2"/>
                        </svg>
                    </span>
                        <input x-data x-mask:dynamic="$money($input, ',','.')" type="text"
                               class="input-highlight {{$color}} text-{{$color}} w-100 text-lg"
                               style="padding-left: 3.5rem"
                               wire:model.defer="transacao.valor">
                    </div>
                    <div class=" @error('valor') is-invalid @enderror"></div>
                    @error('valor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 @if($recorrenteOpcao === 'pendentes'||$recorrenteOpcao === 'all') d-none @endif ">
                    <label class="row">
                        <label class="form-label text-muted">Situação</label>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-circle-check text-muted me-2"
                                 width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                <path d="M9 12l2 2l4 -4"/>
                            </svg>
                            {{$situacao}}
                        </div>
                        <span class="col-auto">
                            <label class="form-check form-check-single">
                              <input class="form-check-input-{{$color}}" type="checkbox"
                                     wire:model.defer="transacao.pago"
                                     wire:click="switchSituacao">
                            </label>
                        </span>
                    </label>
                </div>
                <div class="mb-3 @if($recorrenteOpcao === 'pendentes'|| $recorrenteOpcao === 'all' ) d-none @endif">
                    <label class="form-label text-muted">Data Vencimento</label>
                    <div class="form-selectgroup">
                        <label class="form-selectgroup-item">
                            <input type="radio" name="dateOptions" wire:ignore value="today" id="today"
                                   class="form-selectgroup-input">
                            <span class="form-selectgroup-label {{$color}} rounded-5 text-sm">Hoje</span>
                        </label>
                        <label class="form-selectgroup-item">
                            <input type="radio" name="dateOptions" wire:ignore value="yesterday" id="yesterday"
                                   class="form-selectgroup-input">
                            <span class="form-selectgroup-label {{$color}} rounded-5 text-sm">Ontem</span>
                        </label>
                        <label class="form-selectgroup-item">
                            <input id="datePicker" type="radio" wire:ignore name="dateOptions" value="other"
                                   class="form-selectgroup-input">
                            <span class="form-selectgroup-label {{$color}} rounded-5 text-sm">Outra</span>
                        </label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                          d="M0 0h24v24H0z"
                                                                                          fill="none"/><path
                                        d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/><path
                                        d="M16 3l0 4"/><path d="M8 3l0 4"/><path d="M4 11l16 0"/><path
                                        d="M8 15h2v2h-2z"/></svg>
                            </span>
                            <input id="dateOther" type="text"
                                   class="input-highlight border-{{$color}} text-muted pt-1"
                                   readonly style="padding-left: 2.5rem">
                        </div>
                    </div>
                </div>
                <label class="form-label text-muted">Descrição</label>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description"
                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                            <path d="M9 17h6"/>
                            <path d="M9 13h6"/>
                        </svg>
                    </span>
                    <input type="text" class="input-highlight {{$color}} text-muted w-100 text-lg"
                           style="padding-left: 2.5rem"
                           wire:model.defer="transacao.descricao">
                </div>
                <div class="input-icon mb-3" wire:ignore>
                    <label class="form-label text-muted">Categoría</label>
                    <select class="form-select input-highlight select-ignore" id="select-categorias"
                            wire:model.defer="transacao.categoria_id">
                        @foreach($categorias as $categoria)
                            <option value="{{$categoria->id}}"
                                    data-custom-properties="&lt;div class=&quot;badge bg-{{$categoria->cor}} badge-pill me-2&quot;&gt;&lt;i class=&quot;icon text-lg {{$categoria->icone}}&quot;&gt;&lt;/i&gt;&lt;/div&gt;">
                                {{$categoria->nome}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label class="form-label text-muted">Observação</label>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                                                                                  fill="none"/><path
                                d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"/><path
                                d="M13.5 6.5l4 4"/></svg>
                    </span>
                    <input type="text" class="input-highlight {{$color}} text-muted w-100 text-lg"
                           style="padding-left: 2.5rem"
                           wire:model.defer="transacao.observacao">
                </div>
                @if($creating)
                    <label class="form-label text-muted">Recorrência</label>
                    <div class="mb-3">
                        <label class="row">
                            <div class="col text-capitalize">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pin"
                                     width="24"
                                     height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M15 4.5l-4 4l-4 1.5l-1.5 1.5l7 7l1.5 -1.5l1.5 -4l4 -4"/>
                                    <path d="M9 15l-4.5 4.5"/>
                                    <path d="M14.5 4l5.5 5.5"/>
                                </svg>
                                {{$transacaoTipo}} fixa
                            </div>
                            <span class="col-auto">
                            <label class="form-check form-check-single">
                              <input class="form-check-input-{{$color}}" type="checkbox"
                                     wire:model="fixa" wire:click="handleRecorrencia('fx')">
                            </label>
                        </span>
                        </label>
                    </div>
                    <div class="mb-1">
                        <label class="row">
                            <div class="col">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-repeat"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 12v-3a3 3 0 0 1 3 -3h13m-3 -3l3 3l-3 3"/>
                                    <path d="M20 12v3a3 3 0 0 1 -3 3h-13m3 3l-3 -3l3 -3"/>
                                </svg>
                                Repetir
                            </div>
                            <span class="col-auto">
                            <label class="form-check form-check-single">
                              <input class="form-check-input-{{$color}}" type="checkbox"
                                     wire:model="recorrente" wire:click="handleRecorrencia('rr')">
                            </label>
                        </span>
                        </label>
                    </div>
                    <div class="mb-3 row">
                        <div class="mb-3 col-6">
                            <div class="input-icon">
                                <input type="number"
                                       class="input-highlight {{$color}} text-muted w-100 text-lg @if(!$recorrente) border-0 @endif"
                                       style="padding-right: 3.0rem" @if(!$recorrente) disabled @endif
                                       wire:model.defer="transacao.recorrente_vezes">
                                <span class="input-icon-addon me-2 @if($recorrente) text-black @endif">
                                    Vezes
                                </span>
                            </div>
                            @error('transacao.recorrente_vezes')
                            <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-icon mb-3 col-6">
                            <select
                                class="input-highlight {{$color}} w-100 text-lg select-ignore @if(!$recorrente) border-0 text-muted @endif"
                                @if(!$recorrente) disabled @endif
                                wire:model.defer="transacao.recorrente_periodo">
                                <option class="bg-body text-muted text-md" value="Days">Dias</option>
                                <option class="bg-body text-muted text-md" value="Weeks">Semanas</option>
                                <option class="bg-body text-muted text-md" value="Months">Meses</option>
                                <option class="bg-body text-muted text-md" value="Years">Anos</option>
                            </select>
                        </div>
                    </div>
                @else
                    @if($recorrente)
                        <div class="mb-3">
                            <h3>Atenção! Está é uma {{$transacaoTipo}} recorrente.<br>Você deseja:</h3>
                            <div>
                                <label class="form-check">
                                    <input class="form-check-input-{{$color}}" type="radio" value="this"
                                           name="recorrente_opcao"
                                           style="float: left;margin-left: -1.5rem;" wire:model="recorrenteOpcao">
                                    <span class="form-check-label">Editar somente esta</span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input-{{$color}}" type="radio" value="pendentes"
                                           name="recorrente_opcao"
                                           style="float: left;margin-left: -1.5rem;" wire:model="recorrenteOpcao">
                                    <span class="form-check-label">Editar essa e todas as pendentes</span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input-{{$color}}" type="radio" value="all"
                                           name="recorrente_opcao"
                                           style="float: left;margin-left: -1.5rem;" wire:model="recorrenteOpcao">
                                    <span class="form-check-label">Editar todas (incluindo efetivadas)</span>
                                </label>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="btn-list mx-5 mb-3">
                <button wire:click="{{$method}}" class="btn btn-{{$color}} ms-auto rounded-5 w-25">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#nova-transacao-modal').modal({
            backdrop: 'static',
        })

        let dateOptions = $('.form-selectgroup-input');
        let customDateInput = $('#datePicker');
        let picker = initializeDatePicker(customDateInput[0]);

        dateOptions.click(function () {
            handleDateSelection($(this).val(), picker);
        });

        // dateOptions.each(function () {
        //     if ($(this).is(':checked')) {
        //         handleDateSelection($(this).val(), picker);
        //     }
        // });

        function initializeDatePicker(input) {
            return new Pikaday({
                field: input,
                theme: localStorage.getItem('theme') === 'dark' ? 'dark-theme' : '',
                format: 'YYYY-MM-DD',
                position: 'top left',
                i18n: {
                    previousMonth: 'Mês anterior',
                    nextMonth: 'Próximo mês',
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
                },
                onSelect: function () {
                    updateDates(this.getDate());
                },
                onClose: function () {
                    let date = this.getDate();
                    if (date !== null)
                        updateDates(date);
                    else {
                        let d = new Date();
                        updateDates(d);
                    }
                },
            });
        }

        function handleDateSelection(value, picker) {
            let today = new Date();
            let dateValue;
            if (value === 'today') {
                dateValue = today;
                picker.setDate(dateValue);
                updateDates(dateValue);
            } else if (value === 'yesterday') {
                dateValue = new Date(today.setDate(today.getDate() - 1));
                picker.setDate(dateValue);
                updateDates(dateValue);
            } else if (value === 'other') {
                picker.show();
            }
        }

        function formatDateForDisplay(date) {
            let d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [day, month, year].join('/');
        }

        function formatDateForInput(date) {
            let d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

        function updateDates(date) {
            const displayDate = formatDateForDisplay(date);
            const inputDate = formatDateForInput(date);
            $('#dateOther').val(`Data: ${displayDate}`);
            @this.
            data_vencimento = inputDate;
        }

        let el;
        window.TomSelect && (new TomSelect(el = document.getElementById('select-categorias'), {
            focus: false,
            copyClassesToDropdown: false,
            dropdownParent: el.parentNode,
            controlInput: '<input>',
            render: {
                item: function (data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
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

        Livewire.on('$refresh', () => {
            $('#nova-transacao-modal').modal('hide')
        })

        Livewire.on('showModal', () => {
            updateDates(new Date());
            $('#today').prop('checked', true);
        })

        Livewire.on('edit', (data) => {
            const data_vencimento = data.data_vencimento
            updateDates(data_vencimento);
            let date = new Date(data_vencimento);
            let today = new Date();
            let yesterday = new Date(today.setDate(today.getDate() - 1));
            date = formatDateForInput(date);
            today = formatDateForInput(new Date());
            yesterday = formatDateForInput(yesterday)

            if (date === today) {
                $('#today').prop('checked', true);
            } else if (date === yesterday) {
                $('#yesterday').prop('checked', true);
            } else {
                $('#datePicker').prop('checked', true);
            }
            el.tomselect.setValue(data.categoria_id, true);
        })
    });
</script>
