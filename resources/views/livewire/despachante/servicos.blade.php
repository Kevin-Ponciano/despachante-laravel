<div>
    <div class="page-header d-print-none">
        <div class="container-narrow">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Serviços
                    </h2>
                    <div class="page-subtitle">
                        Serviços prestados pelo despachante
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-narrow">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <h5 class="col page-title">
                                Selecione o serviço
                            </h5>
                            <div class="col-auto" wire:ignore>
                                <select id="select-servico" class="form-select"
                                        wire:model="servico.id" wire:change="switchServico">
                                    <option value="-1">Novo Serviço</option>
                                    @foreach($servicos as $item)
                                        <option value="{{$item->id}}">{{$item->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <fieldset class="form-fieldset">
                            @if($servico['id'] == '-1')
                                <h4>Cadastrar Novo Serviço</h4>
                            @else
                                <h4>Editar Serviço</h4>
                            @endif
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nome</label>
                                        <input type="text"
                                               class="form-control @error('servico.nome') is-invalid @enderror"
                                               wire:model.defer="servico.nome">
                                        @error('servico.nome') <span
                                            class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Valor</label>
                                        <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>
                                            <input x-data x-mask:dynamic="$money($input, ',','.')"
                                                   type="text"
                                                   class="form-control px-5 w-50 @error('servico.preco') is-invalid @enderror"
                                                   wire:model.defer="servico.preco">
                                            @error('servico.preco') <span
                                                class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Descrição</label>
                                        <textarea rows="5" type="text" class="form-control"
                                                  wire:model.defer=servico.descricao></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <button class="btn btn-primary" wire:click="createOrUpdate">Salvar</button>
                                    @if($servico['id'] != '-1')
                                        <button class="btn btn-ghost-danger" data-bs-toggle="modal"
                                                data-bs-target="#modal-delete">Excluir
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <x-delete-confirmation/>
    </div>
