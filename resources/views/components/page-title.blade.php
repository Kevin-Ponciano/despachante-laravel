<div class="page-header m-0 d-print-none">
    <div class="{{$classContainer?? 'container'}}">
        <div class="d-flex justify-content-between">
            <div>
                <div class="d-flex gap-2">
                    <div>
                        <div class="page-title">
                            {{$title}}
                        </div>
                        <div class="page-subtitle">
                            {{$subtitle ?? ''}}
                        </div>
                    </div>
                    @if($status??false)
                        <div class="mt-5">
                            <span class="page-subtitle">Responsável: </span>
                            {{$responsavel->name ?? ''}}
                        </div>
                    @endif
                </div>
            </div>
            @if($status ?? false)
                <div class="mt-2">
                    <div>
                        <div class="text-center h3 m-0">
                            <span class="badge {{$statusDisplay[1]}}">{{$statusDisplay[0]}}
                        </div>
                        @if($status === 'co')
                            <div>
                                <span class="page-subtitle">Concluído por: </span>
                                {{$concluidoPor->name?? ''}}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mt-2">
                    <div x-data="{status : @entangle('status') }" class="btn-list">
                        <button class="btn btn-primary" x-show="status==='ab' || status==='pe'" wire:click="play">
                            Play
                        </button>
                        <button class="btn @if($status==='sc') btn-warning @else btn-success @endif"
                                x-show="status==='ea' || status==='sc'"
                                wire:click="conclude">
                            Concluir
                        </button>
                        <button class="btn btn-danger" x-show="status!=='ex'" data-bs-toggle="modal"
                                data-bs-target="#modal-delete">
                            Excluir
                        </button>
                    </div>
                </div>
                <x-delete-confirmation/>
                <x-modal-aviso>
                    <div class="text-center">
                        <h3>Pedido Possui Pendências.</h3>
                        <div>Para prosseguir o pedido é necessário resolver as pendências.</div>
                    </div>
                </x-modal-aviso>
            @endif
        </div>
    </div>
</div>
