<div>
    <x-page-title title="Processos"/>
        <x-livewire-table>
            <x-slot:filters>
                <div class="text-muted">
                    Clientes:
                    <div class="me-2 d-inline-block" wire:ignore>
                        <select id="select-cliente" class="form-select-sm">
                            <option value="-1">Todos</option>
                            @foreach(\App\Models\Cliente::all() as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-muted">
                    Status:
                    <div class="me-2 d-inline-block">
                        <select class="form-select form-select-sm">
                            <option value="100">Todos</option>
                            <option value="10">Abertos</option>
                            <option value="25">Em Andamento</option>
                            <option value="50">Concluídos</option>
                        </select>
                    </div>
                </div>
                <div class="text-muted">
                    Tipo:
                    <div class="me-2 d-inline-block">
                        <select class="form-select form-select-sm">
                            <option value="100">Todos</option>
                            <option value="100">Solicitação de Serviço</option>
                            <option value="10">RENAV</option>
                        </select>
                    </div>
                </div>
                <div class="text-muted">
                    Tipo do Comprador:
                    <div class="me-2 d-inline-block">
                        <select class="form-select form-select-sm">
                            <option value="100">Todos</option>
                            <option value="100">Loja</option>
                            <option value="10">Terceiro</option>
                        </select>
                    </div>
                </div>
                <div class="text-muted">
                    Retorno da Pendência:
                    <div class="me-2 d-inline-block">
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
        </x-livewire-table>
    </div>


