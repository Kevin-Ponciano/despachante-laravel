<div id="pendencias" x-data="{createPendencia: @entangle('createPendencia')}">
    <div class="pt-0 table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th class="text-center">Status</th>
                <th class="text-center">Concluída em</th>
                <th class="text-center">
                    Resolvido
                    <i class="ti ti-check text-green"></i>
                </th>
                @if(Auth::user()->isDespachante())
                    <th></th>
                @endif
            </tr>
            </thead>
            <tbody class="px-1">
            @if(Auth::user()->isDespachante())
                <tr x-show="createPendencia">
                    <td>
                        <input type="text" class="form-control form-control-sm" wire:model.defer="name"
                               placeholder="Nome">
                    </td>
                    <td colspan="2">
                        <input type="text" class="form-control form-control-sm"
                               wire:model.defer="observacao"
                               placeholder="Observação">
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" wire:click="store">
                            Criar pendência
                        </button>
                    </td>
                    <td></td>
                </tr>
            @endif
            @forelse($pendencias as $pendencia)
                <tr data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="OBS.: {{$pendencia->observacao}}">
                    <td class="text-break">{{$pendencia->nome}}</td>
                    <td class="text-center">
                        <span class="badge @if($pendencia->status==='co') bg-success @else bg-warning @endif">
                            {{$pendencia->getStatus()}}
                        </span>
                    </td>
                    <td class="text-center text-nowrap">{{$pendencia->getConcludedAt()}}</td>
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input-success"
                               @if(!Auth::user()->isDespachante()) disabled @endif
                               @if($pendencia->status==='co') checked
                               @endif
                               wire:click="resolverPendencia({{$pendencia->id}})">
                    </td>
                    @if(Auth::user()->isDespachante())
                        <td class="text-center">
                            <button class="btn btn-sm btn-ghost-red"
                                    wire:click="deletePendencia({{$pendencia->id}})">
                                <i class="ti ti-trash-x"></i>
                            </button>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhuma pendência encontrada</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if(Auth::user()->isDespachante())
        <div class="mt-2 d-flex justify-content-between">
            <button x-on:click="createPendencia=true" class="btn btn-sm btn-ghost-warning"
                    data-bs-placement="top" data-bs-toggle="tooltip"
                    data-bs-original-title="Cria uma Pendência para o personalizada para o Pedido">
                <i class="ti ti-alert-triangle px-2"></i>
                Nova pendência
            </button>
            <button class="btn btn-sm btn-ghost-blue" wire:click="resolverTodas"
                    data-bs-placement="top" data-bs-toggle="tooltip"
                    data-bs-original-title="Marca as pendências como resolvidas e define o Status do Pedido como Aberto"
                    data-bs-dismiss="modal">
                <i class="ti ti-checks px-2"></i>
                Resolver todas
            </button>
        </div>
    @endif
</div>
