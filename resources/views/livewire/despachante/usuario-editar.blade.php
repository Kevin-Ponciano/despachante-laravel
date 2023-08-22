<div>
    <x-page-title title="Editar Cliente"/>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col">
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label class="form-label">Usuário</label>
                                    <x-action-message class="ms-2" on="savedName">
                                        Alterado com sucesso!
                                    </x-action-message>
                                </div>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       wire:model.defer="name" wire:change="changeName">
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label class="form-label">E-mail</label>
                                    <x-action-message class="ms-2" on="savedEmail">
                                        Alterado com sucesso!
                                    </x-action-message>
                                </div>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       wire:model.defer="email" wire:change="changeEmail">
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label class="form-label">Função</label>
                                    <x-action-message class="ms-2" on="savedRole">
                                        Alterado com sucesso!
                                    </x-action-message>
                                </div>
                                <select class="form-select @error('role') is-invalid @enderror"
                                        wire:model.defer="role" wire:change="changeRole">
                                    <option value="du">Usuário</option>
                                    <option value="da">Administador</option>
                                </select>
                                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between gap-2">
                        <a href="#" class="btn btn-ghost-warning">
                            Redefinir Senha
                        </a>
                        <div class="col-auto ms-auto d-print-none">
                            <div x-data="{ status: @entangle('status')}" class="btn-list">
                                @if(Auth::user()->id != $user->id)
                                    <button x-show="status==='at'" class="btn btn-danger" wire:click="switchStatus">
                                        Inativar Usuário
                                    </button>
                                    <button x-show="status==='in'" class="btn btn-ghost-danger" data-bs-toggle="modal"
                                            data-bs-target="#modal-delete">
                                        Excluir Usuário
                                    </button>
                                @endif
                                <button x-show="status==='in'" class="btn btn-success" wire:click="switchStatus">
                                    Ativar Usuário
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-delete-confirmation/>
</div>
