<div class="container-xl">
    <fieldset class="form-fieldset">
        <div class="d-flex justify-content-between mb-2">
            {{$filters}}
        </div>
        <div class="d-flex">
            <div class="text-muted">
                Exibir
                <div class="mx-2 d-inline-block">
                    <select class="form-select form-select-sm">
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
                    <input type="text" class="form-control form-control-sm">
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
                <tbody class="table-tbody">
                {{$tbody}}
                </tbody>
            </table>
        </div>
    </div>
</div>
