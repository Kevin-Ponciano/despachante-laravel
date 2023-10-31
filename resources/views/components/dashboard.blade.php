<div class="page-wrapper">
    <div class="page-header d-print-none z-2">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Atualização Automática:
                        <span id="countdown-timer"></span>
                    </div>
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a id="on-update-dashboard" class="mt-2 text-success cursor-pointer" data-bs-toggle="tooltip"
                           data-bs-placement="auto" aria-label="Ativar/Desativar Atualização Automática"
                           data-bs-original-title="Ativar/Desativar Atualização Automática">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-2"
                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M15 4.55a8 8 0 0 0 -6 14.9m0 -4.45v5h-5"></path>
                                <path d="M18.37 7.16l0 .01"></path>
                                <path d="M13 19.94l0 .01"></path>
                                <path d="M16.84 18.37l0 .01"></path>
                                <path d="M19.37 15.1l0 .01"></path>
                                <path d="M19.94 11l0 .01"></path>
                            </svg>
                        </a>
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
        <div id="loading-overlay"
             style="display:none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.7); z-index: 1;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="container container-slim py-4">
                    <div class="text-center">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-xl z-0">
            <div class="h4 m-1 page-pretitle">
                PROCESSOS
            </div>
            <div class="row row-deck row-cards">
                <div class="col-3">
                    <x-card bg="bg-success-lt" titulo="Processos" subtitulo="Abertos"
                            :numero="$qtdProcessosAbertos"
                            :route="$routeProcessosAbertos"
                            icon="ti ti-file-plus"
                    />
                </div>
                <div class="col-3">
                    <x-card bg="bg-primary-lt" titulo="Processos" subtitulo="Em andamento"
                            :numero="$qtdProcessosEmAndamento"
                            :route="$routeProcessosEmAndamento"
                            icon="ti ti-file-analytics"
                    />
                </div>
                <div class="col-3">
                    <x-card bg="bg-warning-lt" titulo="Processos"
                            :subtitulo="Auth::user()->isCliente() ? 'Em Análise' : 'Retornados da Pendência'"
                            :numero="$qtdProcessosRetornados"
                            :route="$routeProcessosRetornados"
                            icon="ti ti-file-symlink"
                    />
                </div>
                <div class="col-3">
                    <x-card bg="bg-warning-lt" titulo="Processos" subtitulo="Pendentes"
                            :numero="$qtdProcessosPendentes"
                            :route="$routeProcessosPendentes"
                            icon="ti ti-file-report"
                    />
                </div>

                @if(Auth::user()->isCliente())
                    <div class="col-3">
                        <x-card bg="bg-instagram-lt" titulo="Processos" subtitulo="Disponível Para Download"
                                :numero="$qtdProcessosDisponivelDownload"
                                :route="$routeProcessosDisponivelDownload"
                                icon="ti ti-download"
                        />
                    </div>
                @endif
            </div>
            <div class="h4 m-1 page-pretitle mt-4">
                Transferências
            </div>
            <div class="row row-deck row-cards">
                <div class="col-3">
                    <x-card bg="bg-success-lt" titulo="Transferências" subtitulo="Abertos"
                            :numero="$qtdAtpvsAbertos"
                            :route="$routeAtpvsAbertos"
                            icon="ti ti-file-plus"
                    />
                </div>
                <div class="col-3">
                    <x-card bg="bg-primary-lt" titulo="Transferências" subtitulo="Em andamento"
                            :numero="$qtdAtpvsEmAndamento"
                            :route="$routeAtpvsEmAndamento"
                            icon="ti ti-file-analytics"
                    />
                </div>
                <div class="col-3">
                    <x-card bg="bg-warning-lt" titulo="Transferências"
                            :subtitulo="Auth::user()->isCliente() ? 'Em Análise' : 'Retornados da Pendência'"
                            :numero="$qtdAtpvsRetornados"
                            :route="$routeAtpvsRetornados"
                            icon="ti ti-file-symlink"
                    />
                </div>
                <div class="col-3">
                    <x-card bg="bg-warning-lt" titulo="Transferências" subtitulo="Pendentes"
                            :numero="$qtdAtpvsPendentes"
                            :route="$routeAtpvsPendentes"
                            icon="ti ti-file-report"
                    />
                </div>
                <div class="col-3">
                    <x-card bg="bg-danger-lt" titulo="Transferências" subtitulo="Solicitado Cancelamento"
                            :numero="$qtdAtpvsSolicitadoCancelamento"
                            :route="$routeAtpvsSolicitadoCancelamento"
                            icon="ti ti-file-x"
                    />
                </div>

                @if(Auth::user()->isCliente())
                    <div class="col-3">
                        <x-card bg="bg-instagram-lt" titulo="Transferências" subtitulo="Disponível Para Download"
                                :numero="$qtdAtpvsDisponivelDownload"
                                :route="$routeAtpvsDisponivelDownload"
                                icon="ti ti-download"
                        />
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/updateDashboard.config.js')}}"></script>
</div>
