<div>
    <x-page-title title="Relatórios"/>
    <div class="container-xl">
        <div class="card">
            {{--            <div class="card-header">--}}
            {{--                <div class="container-xl">--}}
            {{--                    <div class="row g-2 align-items-center">--}}
            {{--                        <div class="col">--}}
            {{--                            <div class="page-title me-2">--}}
            {{--                                Pedidos--}}
            {{--                            </div>--}}
            {{--                            <div class="page-subtitle mt-2">--}}
            {{--                                Relatório de pedidos--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                        <!-- Page title actions -->--}}
            {{--                        <div class="col-auto ms-auto d-print-none">--}}
            {{--                            <div class="btn-list">--}}
            {{--                            <span class="d-none d-sm-inline">--}}
            {{--                                <a href="#" class="btn">--}}
            {{--                                  New view--}}
            {{--                                </a>--}}
            {{--                            </span>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="card-body">
                <div class="d-flex mb-2">
                    <div class="text-muted">
                        Clientes
                        <div class="mx-2 d-inline-block">
                            <select class="form-select form-select-sm">
                                <option value="10">Todos</option>
                                <option value="25">Cliente 1</option>
                                <option value="50">Cliente 2</option>
                                <option value="100">Cliente 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-muted">
                        Status
                        <div class="mx-2 d-inline-block">
                            <select class="form-select form-select-sm">
                                <option value="100">Todos</option>
                                <option value="10">Abertos</option>
                                <option value="25">Em Andamento</option>
                                <option value="50">Concluídos</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-muted ms-auto">
                        <div class="mx-2 d-inline-block">
                            Data Abertura
                            <label class="form-switch toogle-red" style="filter: hue-rotate(493deg) brightness(104 %) !important;">
                                <input class="form-check-input" type="checkbox">
                            </label>
                        </div>
                    </div>
                    <div class="text-muted">
                        Data Inicial
                        <div class="mx-2 d-inline-block">
                            <input type="date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="text-muted ">
                        Data Final
                        <div class="ms-2 d-inline-block">
                            <input type="date" class="form-control form-control-sm">
                        </div>
                    </div>
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
                    <div class="ms-auto text-muted">
                        Exibir Pendências
                        <div class="mx-2 d-inline-block">
                            <input type="checkbox" class="form-check-input">
                        </div>
                    </div>
                    <div class="text-muted">
                        Buscar:
                        <div class="ms-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="relatorio-table" class="card-table table table-hover">
                    <thead>
                    <tr>
                        <th class="end">Num.</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Cliente</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    @foreach($pedidos as $pedido)
                        <tr>
                            <td>{{$pedido->id}}</td>
                            <td>{{$pedido->criado_em}}</td>
                            <td>{{$pedido->status}}</td>
                            <td>{{$pedido->cliente_id}}</td>
                            <td>{{$teste}}</td>
                            <td>
                                <button class="btn btn-danger" wire:click="teste">
                                    Teste
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
