<div>
    <div class="page-header m-0 d-print-none">
        <div class="container-narrow">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="d-flex gap-2">
                        <div>
                            <div class="page-title">
                                Perfil
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-narrow">
        <div class="card">
            <div class="card-body">
{{--                <h3 class="card-title">Foto de Perfil</h3>--}}
{{--                <div class="row align-items-center">--}}
{{--                    <div class="col-auto">--}}
{{--                        <img src="{{$photo? $photo->temporaryUrl(): $user->getProfilePhoto() }}"--}}
{{--                             class="rounded-4 avatar avatar-xl"--}}
{{--                             alt="profile">--}}
{{--                    </div>--}}
{{--                    <div class="col-auto">--}}
{{--                        <div class="col mb-3">--}}
{{--                            <x-action-message on="savedPhoto">--}}
{{--                                Foto atualizada com sucesso!--}}
{{--                            </x-action-message>--}}
{{--                            <x-action-message on="deletedPhoto">--}}
{{--                                Foto removida com sucesso!--}}
{{--                            </x-action-message>--}}
{{--                            <input type="file" accept="image/*"--}}
{{--                                   class="form-control mt-2 @error('photo') is-invalid @enderror"--}}
{{--                                   wire:model="photo"/>--}}
{{--                            @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                        <div class="btn-list gap-2">--}}
{{--                            <a href="#" class="btn btn-primary" wire:click="savePhoto">Upload</a>--}}
{{--                            @if($user->profile_photo_path)--}}
{{--                                <a href="#" class="btn btn-ghost-danger" wire:click="deletePhoto">Remover</a>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <h3 class="card-title mt-4">Informações Pessoais</h3>
                <fieldset class="form-fieldset row g-1">
                    <div class="col-6">
                        <div class="d-flex gap-2">
                            <div class="form-label">Nome</div>
                            <x-action-message on="savedName">
                                Nome atualizado com sucesso!
                            </x-action-message>
                        </div>
                        <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror"
                               wire:model.defer="name">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <a class="btn btn-primary" wire:click="changeName">Alterar Nome</a>
                    </div>
                    <div class="col-6">
                        <div class="d-flex gap-2">
                            <div class="form-label">E-mail</div>
                            <x-action-message on="savedEmail">
                                E-mail atualizado com sucesso!
                            </x-action-message>
                        </div>
                        <input type="email" class="form-control mb-2 @error('email') is-invalid @enderror"
                               wire:model.defer="email">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <a class="btn btn-primary" wire:click="changeEmail">Alterar E-mail</a>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="d-flex gap-2">
                            <div class="form-label">Senha Atual</div>
                            <x-action-message on="savedPassword">
                                Senha atualizada com sucesso!
                            </x-action-message>
                        </div>
                        <input type="password" class="form-control mb-2 @error('oldPassword') is-invalid @enderror"
                               wire:model="oldPassword">
                        @error('oldPassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <a class="btn btn-warning" wire:click="changePassword">Alterar Senha</a>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="form-label">Nova Senha</div>
                        <input type="password"
                               class="form-control mb-2 @error('newPassword') is-invalid @enderror"
                               wire:model="newPassword">
                        @error('newPassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
