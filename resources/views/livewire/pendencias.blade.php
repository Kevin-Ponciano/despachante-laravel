<div>
    @if($isModal)
        <a class="btn bg-body @if($this->hasPending()) text-warning @endif position-relative"
           data-bs-target="#modal-pendencias" data-bs-toggle="modal">
            Pendências
            @if($this->hasPending())
                <span class="badge bg-orange badge-notification badge-blink"></span>
            @endif
        </a>
        <x-modal id="modal-pendencias" title="Pendências" class-body="p-1">
            <x-slot:modal-body>
                <x-pendencias-table :pendencias="$pendencias"/>
            </x-slot:modal-body>
            <x-slot:modal-footer>
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar
                </button>
            </x-slot:modal-footer>
        </x-modal>
    @else
        <x-accordion id="accordion-pendencias" :active="false" class="h3 mb-0">
            <x-slot:title>
                <div
                    class="@if($this->hasPending()) text-warning @endif">
                    Pendências
                    @if($this->hasPending())
                        <i class="badge bg-warning badge-blink ms-1 p-1"></i>
                    @endif
                </div>
            </x-slot:title>
            <x-slot:body>
                <x-pendencias-table :pendencias="$pendencias"/>
            </x-slot:body>
        </x-accordion>
    @endif
</div>
