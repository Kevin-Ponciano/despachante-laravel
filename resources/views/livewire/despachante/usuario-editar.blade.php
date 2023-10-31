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
                                <div class="mt-2">
                                    @if(Auth::user()->id == $user->id)
                                        <a href="{{route('despachante.perfil')}}" class="btn btn-ghost-warning">
                                            Redefinir Senha
                                        </a>
                                    @else
                                        <button type="submit" wire:click="resetPassword" class="btn btn-ghost-warning">
                                            Redefinir Senha
                                        </button>
                                    @endif
                                </div>
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
                                <div x-data="{ status: @entangle('status')}" class="btn-list mt-2">
                                    @if(Auth::user()->id != $user->id)
                                        <button x-show="status==='at'" class="btn btn-danger" wire:click="switchStatus">
                                            Inativar Usuário
                                        </button>
                                        <button x-show="status==='in'" class="btn btn-ghost-danger"
                                                data-bs-toggle="modal"
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
                        <div class="col">
                            <fieldset class="form-fieldset">
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <label class="form-label">Permissões</label>
                                        <x-action-message class="ms-2" on="savedPermission">
                                            Alterado com sucesso!
                                        </x-action-message>
                                    </div>
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                            <label class="form-check col-6">
                                                <input class="form-check-input" type="checkbox"
                                                       wire:click="changePermission"
                                                       wire:model="userPermissions.{{$permission['name']}}">
                                                <span class="form-check-label">{{$permission['alias']}}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-delete-confirmation/>
</div>
