<div>
    <x-page-title title="Editar Cliente"/>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label class="form-label">Usuário</label>
                                    <x-action-message class="ms-2" on="savedName">
                                        Alterado com sucesso!
                                    </x-action-message>
                                </div>
                                <input type="text" class="form-control" name="nome"
                                       wire:model.defer="nome" wire:change="changeName">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label class="form-label">E-mail</label>
                                    <x-action-message class="ms-2" on="savedName">
                                        Alterado com sucesso!
                                    </x-action-message>
                                </div>
                                <input type="email" class="form-control" name="email"
                                       wire:model.defer="email" wire:change="changeName">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label class="form-label">Função</label>
                                    <x-action-message class="ms-2" on="savedName">
                                        Alterado com sucesso!
                                    </x-action-message>
                                </div>
                                <select class="form-select" name="role"
                                        wire:model.defer="role" wire:change="changeName">
                                    <option value="da">Administador</option>
                                    <option value="du">Usuário</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-between gap-2">
                        <a href="#" class="btn btn-ghost-warning">
                            Redefinir Senha
                        </a>
                        <button class="btn btn-danger">
                            Inativar Cliente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
