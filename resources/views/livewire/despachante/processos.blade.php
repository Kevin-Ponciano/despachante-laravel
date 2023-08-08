<div>
    <x-page-title title="Processos"/>
    <x-livewire-table :data="$pedidos">
        <x-slot:filters>
            <div class="text-muted">
                Clientes:
                <div class="me-2 d-inline-block" wire:ignore>
                    <select id="select-cliente" class="form-select-sm" wire:model="cliente">
                        <option value="">Todos</option>
                        @foreach($clientes as $cliente)
                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-muted">
                Status:
                <div class="me-2 d-inline-block">
                    <select class="form-select form-select-sm" wire:model="status">
                        <option value="">Todos</option>
                        <option value="ab">Abertos</option>
                        <option value="ea">Em Andamento</option>
                        <option value="pe">Pendentes</option>
                        <option value="co">Concluídos</option>
                    </select>
                </div>
            </div>
            <div class="text-muted">
                Tipo:
                <div class="me-2 d-inline-block">
                    <select class="form-select form-select-sm" wire:model="tipo">
                        <option value="">Todos</option>
                        <option value="ss">Solicitação de Serviço</option>
                        <option value="rv">RENAVE</option>
                    </select>
                </div>
            </div>
            <div class="text-muted">
                Tipo do Comprador:
                <div class="me-2 d-inline-block">
                    <select class="form-select form-select-sm" wire:model="comprador">
                        <option value="">Todos</option>
                        <option value="lj">Loja</option>
                        <option value="tc">Terceiro</option>
                    </select>
                </div>
            </div>
            <div class="text-muted">
                Retorno da Pendência:
                <div class="me-2 d-inline-block">
                    <select class="form-select form-select-sm" wire:model="retorno">
                        <option value="">Todos</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
            </div>
        </x-slot:filters>
        <x-slot:thead>
            <tr>
                <th wire:click="sortBy('numero_pedido')">Num. Pedido
                    <i class="ti ti-arrow-big-{{$sortField === 'id' ? $iconDirection : null}}-filled"></i></th>
                <th wire:click="sortBy('nome')">cliente
                    <i class="ti ti-arrow-big-{{$sortField === 'nome' ? $iconDirection : null}}-filled"></i></th>
                <th wire:click="sortBy('comprador_nome')">nome do comprador
                    <i class="ti ti-arrow-big-{{$sortField === 'comprador_nome' ? $iconDirection : null}}-filled"></i>
                </th>
                <th wire:click="sortBy('placa')">placa
                    <i class="ti ti-arrow-big-{{$sortField === 'placa' ? $iconDirection : null}}-filled"></i></th>
                <th wire:click="sortBy('tipo')">Tipo Pedido
                    <i class="ti ti-arrow-big-{{$sortField === 'tipo' ? $iconDirection : null}}-filled"></i></th>
                <th wire:click="sortBy('atualizado_em')">atualizado às
                    <i class="ti ti-arrow-big-{{$sortField === 'atualizado_em' ? $iconDirection : null}}-filled"></i>
                </th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
            @forelse($pedidos as $pedido)
                <tr class="cursor-pointer"
                    onclick="window.location='{{route('despachante.processos.show', $pedido->numero_pedido)}}'">
                    <td>{{$pedido->numero_pedido}}</td>
                    <td>{{$pedido->cliente->nome}}</td>
                    <td>{{$pedido->comprador_nome}}</td>
                    <td>{{$pedido->placa}}</td>
                    <td>{{$pedido->processo->tipo()}}</td>
                    <td>{{$pedido->atualizado_em()}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="d-flex justify-content-center">
                            <span class="text-muted">
                                Nenhum Processo Encontrado...
                            </span>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-slot:tbody>
    </x-livewire-table>
</div>
