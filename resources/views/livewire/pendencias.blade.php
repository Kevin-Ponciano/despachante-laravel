<x-accordion id="accordion-pendencias" :active="false" class="h3 mb-0">
    <x-slot:title>
        <div
            class="@if($this->hasPending()) text-warning @endif">
            Pendências
            @if($this->hasPending())
                <i class="badge bg-warning badge-blink ms-1 p-1"></i>
            @endif
        </div>
    </x-slot:title>
    <x-slot:body>
        <div id="pendencias" x-data="{createPendencia: @entangle('createPendencia')}">
            <div class="pt-0 table-responsive">
                <table class="table table-hover table-sm ">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Concluída em</th>
                        <th class="text-center">
                            Resolvido
                            <i class="ti ti-check text-green"></i>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr x-show="createPendencia">
                        <td>
                            <input type="text" class="form-control form-control-sm" wire:model.defer="name"
                                   placeholder="Nome">
                        </td>
                        <td colspan="2">
                            <input type="text" class="form-control form-control-sm" wire:model.defer="observacao"
                                   placeholder="Observação">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" wire:click="store">
                                Criar pendência
                            </button>
                        </td>
                        <td></td>
                    </tr>
                    @forelse($pendencias as $pendencia)
                        <tr data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="OBS.: {{$pendencia->observacao}}">
                            <td class="text-break">{{$pendencia->nome}}</td>
                            <td class="text-center">
                                {{--TODO: Centralizar o badge--}}
                                <span
                                    class="badge @if($pendencia->status==='co') bg-success @else bg-warning @endif">{{$pendencia->status()}}</span>
                            </td>
                            <td class="text-center text-nowrap">{{$pendencia->concluido_em()}}</td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input" @if($pendencia->status==='co') checked
                                       @endif
                                       wire:click="resolverPendencia({{$pendencia->id}})">
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-ghost-red"
                                        wire:click="deletePendencia({{$pendencia->id}})">
                                    <i class="ti ti-trash-x"></i>
                                </button>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Nenhuma pendência encontrada</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
            <div class="mt-2 d-flex justify-content-between">
                <button x-on:click="createPendencia=true" class="btn btn-sm btn-ghost-warning">
                    <i class="ti ti-alert-triangle px-2"></i>
                    Nova pendência
                </button>
                <button class="btn btn-sm btn-ghost-blue" wire:click="resolverTodas">
                    <i class="ti ti-checks px-2"></i>
                    Resolver todas
                </button>
            </div>
        </div>
    </x-slot:body>
</x-accordion>
