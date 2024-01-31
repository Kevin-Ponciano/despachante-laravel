<div>
    <div class="page-body">
        <div class="container">
            <x-table id="servicos-table"
                     title="Serviços"
                     subtitle="Lista de Serviços Prestados"
            >
                <x-slot:actions>
                    <a href="{{route('despachante.servicos.editar',-1)}}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus"></i>
                        Cadastrar Novo Serviço
                    </a>
                </x-slot:actions>
                <x-slot:thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center">Criado Em</th>
                        <th></th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
                </x-slot:tbody>
            </x-table>
        </div>
    </div>
</div>
