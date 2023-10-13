<div class="container-fluid">
    <fieldset class="form-fieldset">
        <div class="d-flex justify-content-start gap-2 mb-2">
            {{$filters}}
            <div>
                <a class="btn btn-sm btn-secondary mb-1" data-bs-toggle="tooltip" data-bs-placement="top"
                   aria-label="Remover Filtros" data-bs-original-title="Remover Filtros" wire:click="clearFilters">
                    <i class="ti ti-x"></i>
                </a>
            </div>
        </div>
        <div class="d-flex">
            <div class="text-muted">
                Exibir
                <div class="mx-2 d-inline-block">
                    <select class="form-select form-select-sm" wire:model="paginate">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                resultados por página
            </div>
            <div class="text-muted ms-auto">
                Buscar:
                <div class="ms-2 d-inline-block">
                    <input type="text" class="form-control form-control-sm" wire:model="search">
                </div>
            </div>
        </div>
    </fieldset>
    <div class="card">
        <div class="table-responsive">
            <table class="card-table table table-hover">
                <thead>
                {{$thead}}
                </thead>
                <tbody wire:loading.class="opacity-50" class="table-tbody">
                {{$tbody}}
                </tbody>
            </table>
        </div>
        <div class="card-footer pt-2 py-0">
            {{$data->links()}}
        </div>
    </div>
</div>
