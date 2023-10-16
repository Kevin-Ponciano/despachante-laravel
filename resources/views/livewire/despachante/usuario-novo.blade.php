<div>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       wire:model.defer="name">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       wire:model.defer="email">
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col mt-5">
            <div class="ms-7 fw-bold font-monospace">Disponível<span
                    class="badge bg-red text-red-fg ms-2">{{$qtd_usuarios}}</span>
                <x-helper>
                    <p>Representa o número de usuários que ainda podem ser cadastrados.</p>
                    <p>Para aumentar o número de usuários disponíveis, entre em contato com o suporte
                        <br> ou deleta os usuários inativos.</p>
                </x-helper>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                   wire:model.defer="password">
            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="col">
            <label class="form-label">Função</label>
            <select class="form-select" name="role" wire:model.defer="role">
                <option value="du">Usuário</option>
                <option value="da">Administrador</option>
            </select>
        </div>
    </div>
    <span class="text-muted">Ao cadastrar um novo usuário, será enviado um e-mail com as credenciais de acesso.</span>

    <div class="d-flex justify-content-between mx-1">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal"
                wire:click="clearFields">Cancelar
        </button>
        <button class="btn btn-primary" wire:click="store">Salvar</button>
    </div>
</div>
