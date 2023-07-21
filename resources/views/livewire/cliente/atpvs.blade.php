<div x-data>
    <x-page-title title="ATPVs"/>
    <x-livewire-table>
        <x-slot:filters>
            <div class="">
                Status:
                <div class="me-2 d-inline-block text-muted">
                    <select class="form-select form-select-sm">
                        <option value="100">Todos</option>
                        <option value="10">Abertos</option>
                        <option value="25">Em Andamento</option>
                        <option value="50">Concluídos</option>
                    </select>
                </div>
            </div>
            <div class="">
                Tipo:
                <div class="me-2 d-inline-block text-muted">
                    <select class="form-select form-select-sm">
                        <option value="100">Todos</option>
                        <option value="100">ATPV</option>
                        <option value="10">RENAVE</option>
                    </select>
                </div>
            </div>
            <div class="">
                Disponível para Download:
                <div class="me-2 d-inline-block text-muted">
                    <select class="form-select form-select-sm">
                        <option value="100">Todos</option>
                        <option value="10">Sim</option>
                        <option value="10">Não</option>
                    </select>
                </div>
            </div>
        </x-slot:filters>
        <x-slot:thead>
            <tr>
                <th>id</th>
                <th>Comprador E-mail</th>
                <th>Vendedor E-mail</th>
                <th>Aberto às</th>
                <th>Download Documentos</th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
            @foreach($atpvs as $atpv)
                <tr class="cursor-pointer" onclick="window.location='{{route('cliente.atpvs.show', $atpv->id)}}'">
                    <td>{{$atpv->id}}</td>
                    <td>{{$atpv->comprador_email}}</td>
                    <td>{{$atpv->vendedor_email}}</td>
                    <td>{{$atpv->created_at}}</td>
                    <td>
                        <button class="btn btn-primary" onclick="$(this).parent().parent().removeAttr('onclick')"
                        wire:click="teste({{$atpv->id}})">
                            <i class="icon ti ti-download"></i>
                            Download
                        </button>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>
    </x-livewire-table>
</div>


