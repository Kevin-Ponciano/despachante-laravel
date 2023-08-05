<div class="modal modal-blur fade" id="modal-novo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-processo"
                               class="nav-link active"
                               data-bs-toggle="tab"
                               aria-selected="true"
                               role="tab">Processo</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-atpv"
                               class="nav-link"
                               data-bs-toggle="tab"
                               aria-selected="false"
                               role="tab"
                               tabindex="-1">ATPV</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-processo" role="tabpanel">
                            <livewire:processo-novo/>
                        </div>
                        <div class="tab-pane" id="tabs-atpv" role="tabpanel">
                            <livewire:atpv-novo/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('document').ready(function () {
            Livewire.on('$refresh', () => {
                $('#modal-novo').modal('hide')
            })
        })
    </script>
</div>
