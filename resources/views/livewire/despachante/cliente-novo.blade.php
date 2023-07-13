<x-modal id="modal-cliente-novo"
         title="Cadastrar Novo Cliente"
>
    <x-slot:modal_body>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Nome do Cliente</label>
                    <input type="text" class="form-control" name="nome" wire:model.defer="nome">
                </div>
            </div>
        </div>
        <fieldset class="form-fieldset">
            <h4>Tabela de preços <span class="page-subtitle">opcional</span></h4>
            <div class="row">
                <div class="col-3">
                    <div class="mb-3">
                        <label class="form-label">1 Placa</label>
                        <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>

                            <input x-data x-mask:dynamic="$money($input, '.','')"
                                   type="text" class="form-control" name="preco1Placa" wire:model.defer="preco1Placa">
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

                            <input x-data x-mask:dynamic="$money($input, '.','')"
                                   type="text" class="form-control" name="preco2Placa" wire:model.defer="preco2Placa">
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

                            <input x-data x-mask:dynamic="$money($input, '.','')"
                                   type="text" class="form-control" name="precoLoja" wire:model.defer="precoLoja">
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

                            <input x-data x-mask:dynamic="$money($input, '.','')"
                                   type="text" class="form-control" name="precoTerceiro"
                                   wire:model.defer="precoTerceiro">
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

                            <input x-data x-mask:dynamic="$money($input, '.','')"
                                   type="text" class="form-control" name="precoAtpv" wire:model.defer="precoAtpv">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </x-slot:modal_body>
    <x-slot:modal_footer>
        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" wire:click="store">Salvar</button>
    </x-slot:modal_footer>

</x-modal>
