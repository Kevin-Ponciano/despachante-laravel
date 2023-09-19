<div>
    <div class="page-body">
        <div class="container">
            <x-table id="usuarios-table"
                     title="Usuários"
                     subtitle="Lista de Usuários Cadastrados"
            >
                <x-slot:actions>
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block"
                       data-bs-toggle="modal"
                       data-bs-target="#modal-usuario-novo">
                        <i class="ti ti-plus"></i>
                        Cadastrar Novo Usuário
                    </a>
                </x-slot:actions>
                <x-slot:thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Função</th>
                        <th></th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
                </x-slot:tbody>
            </x-table>
        </div>
    </div>
    <x-modal id="modal-usuario-novo"
             title="Cadastrar Novo Usuário"
    >
        <x-slot:modalBody>
            <livewire:despachante.usuario-novo/>
        </x-slot:modalBody>
    </x-modal>
</div>
