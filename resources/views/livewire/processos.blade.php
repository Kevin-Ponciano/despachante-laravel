<div>

    <x-page-title title="Processos" class-container="container-fluid"/>
    <x-livewire-table :data="$pedidos">
        <x-slot:filters>
            @can('[DESPACHANTE] - Acessar Sistema')
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
            @endcan
            <div class="text-muted">
                Status:
                <div class="me-2 d-inline-block">
                    <select class="form-select form-select-sm" wire:model="status">
                        <option value="">Todos</option>
                        <option value="ab">Abertos</option>
                        <option value="ea">Em Andamento</option>
                        <option value="pe">Pendentes</option>
                        <option value="rp">@if(Auth::user()->isDespachante())
                                Retorno Pendência
                            @else
                                Em Análise
                            @endif</option>
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
                Apenas Disponíveis para Download:
                <div class="me-2 d-inline-block">
                    <input class="form-check-input" type="checkbox" wire:model="downloadDisponivel">
                </div>
            </div>
        </x-slot:filters>
        <x-slot:thead>
            <tr>
                <th class="cursor-pointer fw-bolder" wire:click="sortBy('numero_pedido')">Num. Pedido
                    <i class="ti ti-arrow-big-{{$sortField === 'numero_pedido' ? $iconDirection : null}}-filled"></i>
                </th>
                @if(Auth::user()->isDespachante())
                    <th class="cursor-pointer" wire:click="sortBy('nome')">cliente
                        <i class="ti ti-arrow-big-{{$sortField === 'nome' ? $iconDirection : null}}-filled"></i></th>
                @endif
                <th class="cursor-pointer" wire:click="sortBy('comprador_nome')">nome do comprador
                    <i class="ti ti-arrow-big-{{$sortField === 'comprador_nome' ? $iconDirection : null}}-filled"></i>
                </th>
                <th class="cursor-pointer" wire:click="sortBy('placa')">placa
                    <i class="ti ti-arrow-big-{{$sortField === 'placa' ? $iconDirection : null}}-filled"></i></th>
                @if($status === 'ea')
                    <th>responsável</th>
                @endif

                <th @if(Auth::user()->isDespachante()) class="cursor-pointer" wire:click="sortBy('tipo')" @endif>
                    Tipo Pedido
                    <i class="ti ti-arrow-big-{{$sortField === 'tipo' ? $iconDirection : null}}-filled"></i></th>
                <th class="cursor-pointer text-center" wire:click="sortBy('status')">
                    Status
                    <i class="ti ti-arrow-big-{{$sortField === 'status' ? $iconDirection : null}}-filled"></i>
                </th>
                <th class="cursor-pointer" wire:click="sortBy('atualizado_em')">atualizado às
                    <i class="ti ti-arrow-big-{{$sortField === 'atualizado_em' ? $iconDirection : null}}-filled"></i>
                </th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
            @forelse($pedidos as $pedido)
                <tr class="cursor-pointer" onclick="window.location.href='{{route('get-pedido',$pedido->numero_pedido)}}'">
                    <td class="fw-bold">{{$pedido->numero_pedido}}</td>
                    @if(Auth::user()->isDespachante())
                        <td>{{$pedido->cliente->nome}}</td>
                    @endif
                    <td>{{$pedido->comprador_nome}}</td>
                    <td>{{$pedido->placa}}</td>
                    @if($status === 'ea')
                        <td>{{$pedido->usuarioResponsavel->name??'-'}}</td>
                    @endif
                    <td>{{$pedido->processo->getTipo()}}</td>
                    <td class="text-center">
                        <div class="badge {{$pedido->getStatus()[1]}} text-white">{{$pedido->getStatus()[0]}}</div>
                    </td>
                    <td>{{$pedido->getUpdatedAt()}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
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
