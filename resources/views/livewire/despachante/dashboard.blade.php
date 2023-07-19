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
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn">
                      New view
                    </a>
                  </span>
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
            <div class="page-pretitle">
                PROCESSOS
            </div>
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-lg-4">
                    <x-card bg="bg-success-lt" titulo="Processos" subtitulo="Abertos" numero="32" :route="route('despachante.processos')"
                            icon="ti ti-file-plus ti"
                    />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-card bg="bg-primary-lt" titulo="Processos" subtitulo="Em andamento" numero="32" :route="route('despachante.processos')"
                            icon="ti ti-file-analytics ti"
                    />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-card bg="bg-danger-lt" titulo="Processos" subtitulo="Pendentes" numero="32" :route="route('despachante.processos')"
                            icon="ti ti-file-report ti"
                    />
                </div>
            </div>
            <div class="page-pretitle mt-2">
                ATPVs
            </div>
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-lg-4">
                    <x-card bg="bg-success-lt" titulo="ATPVs" subtitulo="Abertos" numero="32" :route="route('despachante.atpvs')"
                            icon="ti ti-file-plus ti"
                    />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-card bg="bg-primary-lt" titulo="ATPVs" subtitulo="Em andamento" numero="32" :route="route('despachante.atpvs')"
                            icon="ti ti-file-analytics ti"
                    />
                </div>
                <div class="col-sm-6 col-lg-2">
                    <x-card bg="bg-danger-lt" titulo="ATPVs" subtitulo="Pendentes" numero="32" :route="route('despachante.atpvs')"
                            icon="ti ti-file-report ti"
                    />
                </div>
                <div class="col-sm-6 col-lg-2">
                    <x-card bg="bg-danger-lt" titulo="ATPVs" subtitulo="Solicitado Cancelamento" numero="32" :route="route('despachante.atpvs')"
                            icon="ti ti-file-x ti"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
