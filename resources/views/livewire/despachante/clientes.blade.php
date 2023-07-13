<div>
    <div class="page-body">
        <div class="container-xl">
            <x-table id="clientes-table"
                     title="Clientes"
                     subtitle="Lista de Clientes Cadastrados"
            >
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
</div>

