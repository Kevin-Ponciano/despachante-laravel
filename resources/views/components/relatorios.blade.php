<x-app-layout>
    <x-navbar-despachante/>
    <div class="page-wrapper">
        <x-page-title title="Relatórios"/>
        <div class="container-xl">
            <div class="card">
{{--                <div class="card-header">--}}
{{--                    <div class="container-xl">--}}
{{--                        <div class="row g-2 align-items-center">--}}
{{--                            <div class="col">--}}
{{--                                <div class="page-title me-2">--}}
{{--                                    Pedidos--}}
{{--                                </div>--}}
{{--                                <div class="page-subtitle mt-2">--}}
{{--                                    Relatório de pedidos--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- Page title actions -->--}}
{{--                            <div class="col-auto ms-auto d-print-none">--}}
{{--                                <div class="btn-list">--}}
{{--                                <span class="d-none d-sm-inline">--}}
{{--                                    <a href="#" class="btn">--}}
{{--                                      New view--}}
{{--                                    </a>--}}
{{--                                </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="card-body">
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
                            {{$slot}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
