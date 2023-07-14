<div>
    <div class="page-body">
        <div class="container-xl">
            <x-table id="usuarios-table"
                     title="Usuários"
                     subtitle="Lista de Usuários com acesso ao sistema"
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
                        <th>id</th>
                        <th>Nome</th>
                        <th>Função</th>
                        <th></th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
                    @foreach($usuarios as $usuario)
                        <tr class="cursor-pointer"
                            onclick="window.location='{{route('despachante.usuarios.editar', $usuario->id)}}'">
                            <td>{{$usuario->id}}</td>
                            <td>{{$usuario->name}}</td>
                            <td>{{$usuario->role}}</td>
                            <td class="text-center">
                                <a href="{{route('despachante.usuarios.editar', $usuario->id)}}"
                                   class="btn btn-primary btn-sm">
                                    <i class="ti ti-pencil"></i>
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:tbody>
            </x-table>
        </div>
    </div>
    <livewire:despachante.usuario-novo/>
</div>

