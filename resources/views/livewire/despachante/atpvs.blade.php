<div>
    <x-page-title class-container="container-fluid" title="Transferências"/>
    <x-livewire-table :data="$pedidos">
        <x-slot:filters>
            <div class="">
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
            <div class="">
                Status:
                <div class="me-2 d-inline-block text-muted">
                    <select class="form-select form-select-sm" wire:model="status">
                        <option value="">Todos</option>
                        <option value="ab">Abertos</option>
                        <option value="ea">Em Andamento</option>
                        <option value="pe">Pendentes</option>
                        <option value="sc">Cancelamento</option>
                        <option value="co">Concluídos</option>
                    </select>
                </div>
            </div>
            <div class="">
                Tipo:
                <div class="me-2 d-inline-block text-muted">
                    <select class="form-select form-select-sm" wire:click="checkTipo" wire:model="tipo">
                        <option value="">Todos</option>
                        <option value="at">ATPV</option>
                        <option value="rv">RENAVE</option>
                    </select>
                </div>
            </div>
            @if($tipo === 'rv')
                <div class="">
                    Movimentação:
                    <div class="me-2 d-inline-block text-muted">
                        <select class="form-select form-select-sm" wire:model="movimentacao">
                            <option value="">Todos</option>
                            <option value="in">ENTRADA</option>
                            <option value="out">SAÍDA</option>
                        </select>
                    </div>
                </div>
            @endif
            <div class="">
                Retorno da Pendência:
                <div class="me-2 d-inline-block text-muted">
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
                <th class="cursor-pointer" wire:click="sortBy('numero_pedido')">Num. Pedido
                    <i class="ti ti-arrow-big-{{$sortField === 'numero_pedido' ? $iconDirection : null}}-filled"></i>
                </th>
                <th class="cursor-pointer" wire:click="sortBy('nome')">cliente
                    <i class="ti ti-arrow-big-{{$sortField === 'nome' ? $iconDirection : null}}-filled"></i></th>
                <th class="cursor-pointer" wire:click="sortBy('comprador_nome')">nome do comprador
                    <i class="ti ti-arrow-big-{{$sortField === 'comprador_nome' ? $iconDirection : null}}-filled"></i>
                </th>
                <th class="cursor-pointer" wire:click="sortBy('placa')">placa
                    <i class="ti ti-arrow-big-{{$sortField === 'placa' ? $iconDirection : null}}-filled"></i></th>
                @if($status === 'ea')
                    <th>responsável</th>
                @endif
                <th class="cursor-pointer" wire:click="sortBy('codigo_crv')">Tipo
                    <i class="ti ti-arrow-big-{{$sortField === 'codigo_crv' ? $iconDirection : null}}-filled"></i></th>
                @if($tipo === 'rv')
                    <th class="cursor-pointer" wire:click="sortBy('movimentacao')">Movimentação
                        <i class="ti ti-arrow-big-{{$sortField === 'movimentacao' ? $iconDirection : null}}-filled"></i>
                    </th>
                @endif
                <th class="cursor-pointer" wire:click="sortBy('atualizado_em')">atualizado às
                    <i class="ti ti-arrow-big-{{$sortField === 'atualizado_em' ? $iconDirection : null}}-filled"></i>
                </th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
            @forelse($pedidos as $pedido)
                <tr class="cursor-pointer"
                    onclick="window.location='{{route('despachante.atpvs.show', $pedido->numero_pedido)}}'">
                    <td>{{$pedido->numero_pedido}}</td>
                    <td>{{$pedido->cliente->nome}}</td>
                    <td>{{$pedido->comprador_nome}}</td>
                    <td>{{$pedido->placa}}</td>
                    @if($status === 'ea')
                        <td>{{$pedido->usuarioResponsavel->name??'-'}}</td>
                    @endif
                    <td>{{$pedido->atpv->tipo()}}</td>
                    @if($tipo === 'rv')
                        <td>{{$pedido->atpv->movimentacao()}}</td>
                    @endif
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


