<div>
    <x-page-title title="Editar Cliente"/>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label class="form-label">Nome do Cliente</label>
                                    <x-action-message class="ms-2" on="savedName">
                                        Alterado com sucesso!
                                    </x-action-message>
                                </div>
                                <input type="text" class="form-control w-33" name="nomeCliente"
                                       wire:model.defer="nomeCliente" wire:change="changeName">
                            </div>
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <button class="btn btn-danger">
                                    Inativar Cliente
                                </button>
                            </div>
                        </div>
                    </div>
                    <fieldset class="form-fieldset">
                        <div class="d-flex">
                            <h4>Tabela de Preços</h4>
                            <x-action-message class="ms-2" on="savedName">
                                Alterado com sucesso!
                            </x-action-message>
                        </div>
                        <div class="row gap-5">
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">1 Placa</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-currency-real"></i>
                                        </span>
                                        <input x-data x-mask:dynamic="$money($input, '.','')"
                                               type="text" class="form-control" name="preco1Placa"
                                               wire:model.defer="preco1Placa">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">2 Placas</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-currency-real"></i>
                                        </span>
                                        <input x-data x-mask:dynamic="$money($input, '.','')"
                                               type="text" class="form-control" name="preco2Placa"
                                               wire:model.defer="preco2Placa">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">Processos p/ Loja</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-currency-real"></i>
                                        </span>
                                        <input x-data x-mask:dynamic="$money($input, '.','')"
                                               type="text" class="form-control" name="precoLoja"
                                               wire:model.defer="precoLoja">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
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
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">ATPVs</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-currency-real"></i>
                                        </span>
                                        <input x-data x-mask:dynamic="$money($input, '.','')"
                                               type="text" class="form-control" name="precoAtpv"
                                               wire:model.defer="precoAtpv">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <button class="btn btn-primary" wire:click="alterarPrecos">Alterar Preços</button>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-fieldset">
                        <h4>Usuário Administrador do Cliente</h4>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <label class="form-label">Nome de Usuário</label>
                                        <x-action-message class="ms-2" on="savedName">
                                            Alterado com sucesso!
                                        </x-action-message>
                                    </div>
                                    <input type="text" class="form-control" name="nome" wire:model.defer="nomeUsuario">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" wire:click="alterarNomeUsuario">
                                Alterar Nome de Usuário
                            </button>
                            <a href="#" class="btn btn-ghost-warning">
                                Redefinir Senha
                            </a>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
