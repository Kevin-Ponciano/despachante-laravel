<div>
    <div class="page-body">
        <div class="container-xl">
            <x-table id="processos-table"
                     title="Processos"
                     subtitle="Lista de processos"
            >
                <x-slot:actions>
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                           data-bs-target="#modal-novo">
                            <i class="ti ti-plus"></i>
                            Novo Processo
                        </a>
                </x-slot:actions>
                <x-slot:thead>
                    <tr>
                        <th>id</th>
                        <th>tipo</th>
                        <th>Placas</th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
                    @foreach($processos as $processo)
                        <tr>
                            <td>{{$processo->id}}</td>
                            <td>{{$processo->tipo}}</td>
                            <td>{{$processo->qtd_placas}}</td>
                        </tr>
                    @endforeach
                </x-slot:tbody>
            </x-table>
        </div>
    </div>
</div>

