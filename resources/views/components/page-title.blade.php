<div class="page-header m-0 d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-title">
                    {{$title}}
                </div>
                <div class="page-subtitle">
                    {{$subtitle ?? ''}}
                </div>
            </div>
            @if($status ?? false)
                <div class="col-auto ms-auto">
                    <div x-data="{status : @entangle('status') }" class="btn-list">
                        <button class="btn btn-primary" x-show="status==='ab'" wire:click="play">
                            Play
                        </button>
                        <button class="btn btn-success" x-show="status==='ea'" wire:click="conclude">
                            Concluir
                        </button>
                        <button class="btn btn-danger" x-show="status!=='ex'" data-bs-toggle="modal"
                                data-bs-target="#modal-delete">
                            Excluir
                        </button>
                    </div>
                </div>
                <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" style="display: none;"
                     aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-status bg-danger"></div>
                            <div class="modal-body text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                                     height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path>
                                    <path d="M12 9v4"></path>
                                    <path d="M12 17h.01"></path>
                                </svg>
                                <h3>Tem certeza?</h3>
                                <div class="text-muted">Ao deletar só será possível recuperar em contato com o
                                    administrador do
                                    Sistema.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="w-100">
                                    <div class="row">
                                        <div class="col">
                                            <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                Cancelar
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal"
                                               wire:click="delete">
                                                Excluir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
