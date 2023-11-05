<div>
    <x-page-title title="Relatórios" class-container="container-fluid"/>
    <div class="container-fluid z-2">
        <div class="card">
            <div class="card-body z-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex gap-2 mb-2">
                        <div class="text-muted">
                            Data Inicial
                            <div class="mx-2 d-inline-block">
                                <input id="start_date" type="date" class="form-control form-control">
                            </div>
                        </div>
                        <div class="text-muted ">
                            Data Final
                            <div class="ms-2 d-inline-block">
                                <input id="end_date" type="date" class="form-control form-control">
                            </div>
                        </div>
                        <button id="setDateReport" type="button" class="btn btn-primary">Gerar Relatório</button>
                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                             data-bs-original-title="Gerar um relatório com a soma dos valores">
                            <button disabled id="somatorio"
                                    class="btn btn-azure">
                                Gerar Somatório
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loading-overlay" class="bg-white"
                 style="display:none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <div class="container container-slim py-4">
                        <div class="text-center">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="relatorios-pedido-table" class="fw-bolder z-0"></div>
        </div>
    </div>
    <script src="{{asset('assets/js/WebDataRocks.config.js')}}"></script>

</div>
