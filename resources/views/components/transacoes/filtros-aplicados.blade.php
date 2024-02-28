<div class="mx-4 mt-1">
    <div class="d-flex justify-content-between">
        <div>
            <div class="d-flex flex-wrap gap-2 ">
                <div class="fw-bolder">Filtros:</div>
                @if($filters['date']??false)
                    <div class="badge bg-body-tertiary py-1 rounded-5 text-body">
                        De: {{$filters['date']['start']}} até: {{$filters['date']['end']}}
                    </div>
                @endif
                @if($filters['categorias']??false)
                    @foreach($filters['categorias'] as $categoria)
                        <div class="d-flex badge bg-transparent border-{{$categoria['cor']}} rounded-5 text-body">
                            <i class="icon text-md me-1 {{$categoria['icone']}}"></i>
                            <div class="p-1">{{$categoria['nome']}}</div>
                            <button class="btn btn-sm bg-{{$categoria['cor']}} rounded-5"
                                    wire:click="removeFilter('categorias',{{$categoria['id']}})">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
                @if($filters['situacao']??false)
                    @if($filters['situacao'] === 'pg')
                        <div class="d-flex badge bg-transparent border-success rounded-5 text-body">
                            <i class="icon text-md me-1 ti ti-check"></i>
                            <div class="p-1">Pagas</div>
                            <button class="btn btn-sm bg-success rounded-5"
                                    wire:click="removeFilter('situacao')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @elseif($filters['situacao'] === 'pe')
                        <div class="d-flex badge bg-transparent border-warning rounded-5 text-body">
                            <i class="icon text-md me-1 ti ti-exclamation-mark"></i>
                            <div class="p-1">Pendentes</div>
                            <button class="btn btn-sm bg-warning rounded-5"
                                    wire:click="removeFilter('situacao')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @endif
                @endif
                @if($filters['recorrencia']??false)
                    @if($filters['recorrencia'] === 'rr')
                        <div class="d-flex badge bg-transparent border-primary rounded-5 text-body">
                            <i class="icon text-md me-1 ti ti-repeat"></i>
                            <div class="p-1">Recorrentes</div>
                            <button class="btn btn-sm bg-primary rounded-5"
                                    wire:click="removeFilter('recorrencia')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @elseif($filters['recorrencia'] === 'n/a')
                        <div class="d-flex badge bg-transparent border-secondary rounded-5 text-body">
                            <i class="icon text-md me-1 ti ti-repeat-off"></i>
                            <div class="p-1">Não Recorrentes</div>
                            <button class="btn btn-sm bg-secondary rounded-5"
                                    wire:click="removeFilter('recorrencia')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @endif
                @endif
                @if($filters['tipo']??false)
                    @if($filters['tipo'] === 'in')
                        <div class="d-flex badge bg-transparent border-success rounded-5 text-body">
                            <i class="icon text-md me-1 ti ti-arrow-up"></i>
                            <div class="p-1">Receitas</div>
                            <button class="btn btn-sm bg-success rounded-5"
                                    wire:click="removeFilter('tipo')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @elseif($filters['tipo'] === 'out')
                        <div class="d-flex badge bg-transparent border-danger rounded-5 text-body">
                            <i class="icon text-md me-1 ti ti-arrow-down"></i>
                            <div class="p-1">Despesas</div>
                            <button class="btn btn-sm bg-danger rounded-5"
                                    wire:click="removeFilter('tipo')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="badge badge-empty">
            <a class="btn-close text-body" wire:click="resetFilters" data-bs-toggle="tooltip"
               data-bs-placement="bottom" aria-label="Remover os filtros" data-bs-original-title="Remover os filtros">
            </a>
        </div>
    </div>
</div>
