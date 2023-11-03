<div>
    <x-page-title title="Relatórios" class-container="container-fluid"/>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
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
                </div>
            </div>
            <div wire:ignore class="">
                <table id="relatorios-pedido-table" class="fw-bolder card-table table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Num.</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Criado Em</th>
                        <th class="text-center">Concluído Em</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Comprador</th>
                        <th class="text-center">Placa</th>
                        <th class="text-center">Veículo</th>
                        <th class="text-center">Honorário</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Movimentação</th>
                        <th class="text-center">Serviços</th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/WebDataRocks.config.js')}}"></script>
</div>
