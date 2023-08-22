<div>
    <div class="page-body">
        <div class="container">
            <x-table id="clientes-table"
                     title="Clientes"
                     subtitle="Lista de Clientes Cadastrados"
            >
                <x-slot:actions>
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block"
                       data-bs-toggle="modal"
                       data-bs-target="#modal-cliente-novo">
                        <i class="ti ti-plus"></i>
                        Cadastrar Novo Cliente
                    </a>
                </x-slot:actions>
                <x-slot:thead>
                    <tr>
                        <th class="w-auto">N°</th>
                        <th>Nome</th>
                        <th class="text-center">Status</th>
                        <th></th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
                </x-slot:tbody>
            </x-table>
        </div>
    </div>
    <x-modal id="modal-cliente-novo"
             title="Cadastrar Novo Cliente"
    >
        <x-slot:modal_body>
            <livewire:despachante.cliente-novo/>
        </x-slot:modal_body>
    </x-modal>
</div>
