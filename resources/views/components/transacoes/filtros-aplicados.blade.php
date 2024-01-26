<div class="mx-4 mt-1">
    <div class="d-flex justify-content-between">
        <div>
            <div class="d-flex flex-wrap gap-2 ">
                <div class="fw-bolder">Filtros:</div>
                @if($filters['date'])
                    <div class="badge bg-body-tertiary py-1 rounded-5">
                        De: {{$filters['date']['startDateFilter']}} até: {{$filters['date']['endDateFilter']}}
                    </div>
                @endif
                @if($filters['categorias']??false)
                    @foreach($filters['categorias'] as $categoria)
                        <div class="d-flex badge bg-transparent border-{{$categoria['cor']}} rounded-5">
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
                        <div class="d-flex badge bg-transparent border-success rounded-5">
                            <i class="icon text-md me-1 ti ti-check"></i>
                            <div class="p-1">Pagas</div>
                            <button class="btn btn-sm bg-success rounded-5"
                                    wire:click="removeFilter('situacao')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @elseif($filters['situacao'] === 'pe')
                        <div class="d-flex badge bg-transparent border-warning rounded-5">
                            <i class="icon text-md me-1 ti ti-exclamation-mark"></i>
                            <div class="p-1">Pendentes</div>
                            <button class="btn btn-sm bg-warning rounded-5"
                                    wire:click="removeFilter('situacao')">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    @endif
                @endif
{{--                TODO: Adcionar recorrencia--}}
            </div>
        </div>
        <button class="btn-close btn-close-white" wire:click="resetFilters"></button>
    </div>
</div>
