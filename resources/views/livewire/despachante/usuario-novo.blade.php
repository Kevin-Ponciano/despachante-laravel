<x-modal id="modal-usuario-novo"
         title="Cadastrar Novo Usuário"
         class="modal-md"
>
    <x-slot:modal_body>
        <div class="d-flex justify-content-sm-evenly">
            <div class="col-5">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" wire:model.defer="nome">
                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control" name="email" wire:model.defer="email">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-sm-evenly">
            <div class="col-5">
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" class="form-control" name="password" wire:model.defer="password">
                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label class="form-label">Função</label>
                    <select class="form-select" name="role" wire:model.defer="role">
                        <option value="da">Administrador</option>
                        <option value="du">Usuário</option>
                    </select>
                </div>
            </div>
        </div>
    </x-slot:modal_body>
    <x-slot:modal_footer>
        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" wire:click="store">Salvar</button>
    </x-slot:modal_footer>
</x-modal>
