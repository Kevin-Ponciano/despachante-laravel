<div>
    <div class="page-body">
        <div class="container-xl">
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
                        <th>id</th>
                        <th>Nome</th>
                        <th>Status</th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td>{{$cliente->id}}</td>
                            <td>{{$cliente->nome}}</td>
                            <td>{{$cliente->status}}</td>
                        </tr>
                    @endforeach
                </x-slot:tbody>
            </x-table>
        </div>
    </div>
    <livewire:despachante.cliente-novo/>
</div>

