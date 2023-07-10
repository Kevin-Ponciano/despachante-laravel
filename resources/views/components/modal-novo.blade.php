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
                            <a href="#tabs-processo" onclick="switchButton('processo')"
                               class="nav-link active"
                               data-bs-toggle="tab"
                               aria-selected="true"
                               role="tab">Processo</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-atpv" onclick="switchButton('atpv')"
                               class="nav-link"
                               data-bs-toggle="tab"
                               aria-selected="false"
                               role="tab"
                               tabindex="-1">ATPV</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-processo" role="tabpanel">
                            <livewire:processo-novo/>
                        </div>
                        <div class="tab-pane" id="tabs-atpv" role="tabpanel">
                            <h4>Profile tab</h4>
                            <div>Fringilla egestas nunc quis tellus diam rhoncus ultricies tristique enim at diam,
                                sem
                                nunc
                                amet, pellentesque id egestas velit sed
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button id="submitButton" class="btn btn-primary ms-auto" data-bs-dismiss="modal"
                        onclick="livewire_event()">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 5l0 14"></path>
                        <path d="M5 12l14 0"></path>
                    </svg>
                    Criar novo processo
                </button>
            </div>
        </div>
    </div>
    <script>
        let livewire_event_msg = 'storeProcesso';

        let switchButton = (tipo) => {
            switch (tipo) {
                case 'processo':
                    $('#submitButton').html('Criar novo Processo')
                    livewire_event_msg = 'storeProcesso'
                    break;
                case 'atpv':
                    $('#submitButton').html('Criar novo ATPV')
                    livewire_event_msg = 'storeAtpv'
                    break;
            }
        }

        let livewire_event = () => {
            Livewire.emit(livewire_event_msg)
        }
    </script>
</div>
