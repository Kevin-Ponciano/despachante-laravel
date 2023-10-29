<div>
    <x-page-title title="Editar Cliente" class="container-xl"/>
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
                                <input type="text" class="form-control w-33 @error('nomeCliente') is-invalid @enderror"
                                       name="nomeCliente"
                                       wire:model.defer="nomeCliente" wire:change="updateNomeCliente">
                                @error('nomeCliente') <span
                                    class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                            <div x-data="{ status: @entangle('status')}" class="btn-list">
                                <button x-show="status==='at'" class="btn btn-danger" wire:click="switchStatus">
                                    Inativar Cliente
                                </button>
                                {{--                                <button x-show="status==='in'" class="btn btn-ghost-danger" data-bs-toggle="modal"--}}
                                {{--                                        data-bs-target="#modal-delete">--}}
                                {{--                                    Excluir Cliente--}}
                                {{--                                </button>--}}
                                <button x-show="status==='in'" class="btn btn-success" wire:click="switchStatus">
                                    Ativar Cliente
                                </button>
                            </div>
                        </div>
                    </div>
                    <fieldset x-data class="form-fieldset">
                        <div class="d-flex">
                            <h4>Tabela de Preços</h4>
                            <x-action-message class="ms-2" on="savedPreco">
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
                                        <input x-mask:dynamic="$money($input, ',','.')"
                                               type="text" class="form-control"
                                               wire:model.defer="preco.placa1">
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
                                        <input x-mask:dynamic="$money($input, ',','.')"
                                               type="text" class="form-control"
                                               wire:model.defer="preco.placa2">
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
                                        <input x-mask:dynamic="$money($input, ',','.')"
                                               type="text" class="form-control"
                                               wire:model.defer="preco.loja">
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
                                        <input x-mask:dynamic="$money($input, ',','.')"
                                               type="text" class="form-control"
                                               wire:model.defer="preco.terceiro">
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
                                        <input x-mask:dynamic="$money($input, ',','.')"
                                               type="text" class="form-control"
                                               wire:model.defer="preco.atpv">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
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
                            <div class="col-2">
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
                        <div class="row">
                            <div class="col-2">
                                <button class="btn btn-primary" wire:click="updatePreco">Alterar Preços</button>
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
                                        <x-action-message class="ms-2" on="savedUserClienteName">
                                            Alterado com sucesso!
                                        </x-action-message>
                                    </div>
                                    <input type="text" class="form-control @error('nomeUsuario') is-invalid @enderror"
                                           wire:model.defer="nomeUsuario">
                                    @error('nomeUsuario') <span
                                        class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" wire:click="updateUsuarioCliente">
                                Alterar Nome de Usuário
                            </button>
                            <button type="submit" wire:click="resetPassword" class="btn btn-ghost-warning">
                                Redefinir Senha
                            </button>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    {{--TODO: Adicionar mais detalhe na mensagem de exclusão--}}
    {{--    <x-delete-confirmation/>--}}
</div>
