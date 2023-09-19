<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        {{--                        <span class="d-none d-sm-inline">--}}
                        {{--                            <a href="#" class="btn">--}}
                        {{--                            New view--}}
                        {{--                            </a>--}}
                        {{--                        </span>--}}
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                           data-bs-target="#modal-novo">
                            <i class="ti ti-plus"></i>
                            Novo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="h4 m-1 page-pretitle">
                PROCESSOS
            </div>
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-lg-3">
                    <x-card bg="bg-success-lt" titulo="Processos" subtitulo="Abertos"
                            :numero="$qtdProcessosAbertos"
                            :route="$routeProcessosAbertos"
                            icon="ti ti-file-plus"
                    />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <x-card bg="bg-warning-lt" titulo="Processos" subtitulo="Retornados"
                            :numero="$qtdProcessosRetornados"
                            :route="$routeProcessosRetornados"
                            icon="ti ti-file-symlink"
                    />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <x-card bg="bg-primary-lt" titulo="Processos" subtitulo="Em andamento"
                            :numero="$qtdProcessosEmAndamento"
                            :route="$routeProcessosEmAndamento"
                            icon="ti ti-file-analytics"
                    />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <x-card bg="bg-warning-lt" titulo="Processos" subtitulo="Pendentes" :numero="$qtdProcessosPendentes"
                            :route="$routeProcessosPendentes"
                            icon="ti ti-file-report"
                    />
                </div>
            </div>
            <div class="h4 m-1 page-pretitle mt-4">
                Transferências
            </div>
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-lg-3">
                    <x-card bg="bg-success-lt" titulo="Transferências" subtitulo="Abertos" :numero="$qtdAtpvsAbertos"
                            :route="$routeAtpvsAbertos"
                            icon="ti ti-file-plus"
                    />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <x-card bg="bg-warning-lt" titulo="Transferências" subtitulo="Retornados"
                            :numero="$qtdAtpvsRetornados"
                            :route="$routeAtpvsRetornados"
                            icon="ti ti-file-symlink"
                    />
                </div>
                <div class="col-sm-6 col-lg-2">
                    <x-card bg="bg-primary-lt" titulo="Transferências" subtitulo="Em andamento"
                            :numero="$qtdAtpvsEmAndamento"
                            :route="$routeAtpvsEmAndamento"
                            icon="ti ti-file-analytics"
                    />
                </div>
                <div class="col-sm-6 col-lg-auto">
                    <x-card bg="bg-warning-lt" titulo="Transferências" subtitulo="Pendentes"
                            :numero="$qtdAtpvsPendentes"
                            :route="$routeAtpvsPendentes"
                            icon="ti ti-file-report"
                    />
                </div>
                <div class="col-sm-6 col-lg">
                    <x-card bg="bg-danger-lt" titulo="Transferências" subtitulo="Solicitado Cancelamento"
                            :numero="$qtdAtpvsSolicitadoCancelamento"
                            :route="$routeAtpvsSolicitadoCancelamento"
                            icon="ti ti-file-x"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
