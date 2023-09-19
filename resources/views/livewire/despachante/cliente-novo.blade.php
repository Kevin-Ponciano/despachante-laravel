<div>
    <div class="row">
        <div class="col-4">
            <div class="mb-3">
                <label class="form-label">Nome do Cliente</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror"
                       wire:model.defer="nome">
                @error('nome') <span
                    class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-4">
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror"
                       wire:model.defer="email">
                @error('email') <span
                    class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col mt-5">
            <div class="ms-7 fw-bold font-monospace">Disponível<span
                    class="badge bg-red text-red-fg ms-2">{{$qtd_clientes}}</span>
                <x-helper>
                    <p>Representa o número de clientes que ainda podem ser cadastrados.</p>
                    <p>Para aumentar o número de clientes disponíveis, entre em contato com o suporte
                        <br> ou deleta os clientes inativos.</p>
                </x-helper>
            </div>
        </div>
    </div>
    <fieldset class="form-fieldset">
        <h4>Tabela de Preços <span class="page-subtitle">opcional</span></h4>
        <div x-data class="row">
            <div class="col-3">
                <div class="mb-3">
                    <label class="form-label">1 Placa</label>
                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>

                        <input x-mask:dynamic="$money($input, ',','.')"
                               type="text" class="form-control"
                               wire:model.defer="preco.placa1">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mb-3">
                    <label class="form-label">2 Placas</label>
                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>

                        <input x-mask:dynamic="$money($input, ',','.')"
                               type="text" class="form-control"
                               wire:model.defer="preco.placa2">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mb-3">
                    <label class="form-label">Processos p/ Loja</label>
                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>

                        <input x-mask:dynamic="$money($input, ',','.')"
                               type="text" class="form-control"
                               wire:model.defer="preco.loja">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mb-3">
                    <label class="form-label">Processos p/ Terceiro</label>
                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>

                        <input x-mask:dynamic="$money($input, ',','.')"
                               type="text" class="form-control"
                               wire:model.defer="preco.terceiro">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mb-3">
                    <label class="form-label">ATPVs</label>
                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>

                        <input x-mask:dynamic="$money($input, ',','.')"
                               type="text" class="form-control"
                               wire:model.defer="preco.atpv">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mb-3">
                    <label class="form-label">RENAVE Entrada</label>
                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-currency-real"></i>
                                        </span>
                        <input x-mask:dynamic="$money($input, ',','.')"
                               type="text" class="form-control"
                               wire:model.defer="preco.renaveEntrada">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mb-3">
                    <label class="form-label">RENAVE Saída</label>
                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-currency-real"></i>
                                        </span>
                        <input x-mask:dynamic="$money($input, ',','.')"
                               type="text" class="form-control"
                               wire:model.defer="preco.renaveSaida">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="d-flex justify-content-between mx-1">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal" wire:click="clearFields">
            Cancelar
        </button>
        <button class="btn btn-primary" wire:click="store">Cadastrar</button>
    </div>
</div>
