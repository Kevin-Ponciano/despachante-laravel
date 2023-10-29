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
                    @can('[ADMIN] - Acessar Admin')
                        @if($status??false)
                            <div class="mt-5">
                                <span class="page-subtitle">Responsável: </span>
                                {{$responsavel->name ?? ''}}
                            </div>
                        @endif
                    @endcan
                </div>
            </div>
            @if($status ?? false)
                <div class="mt-2">
                    <div>
                        <div class="text-center h3 m-0">
                            <span class="badge {{$statusDisplay[1]}}">{{$statusDisplay[0]}}
                        </div>
                        @if($status === 'co')
                            <div class="text-center">
                                @if(Auth::user()->isDespachante())
                                    <span class="page-subtitle">Concluído por: </span>
                                    {{$concluidoPor->name?? ''}}
                                @endif
                                <span class="text-muted">{{$concluidoEm?? ''}}</span>
                            </div>
                        @endif
                    </div>
                </div>
                @can('[DESPACHANTE] - Acessar Sistema')
                    <div class="mt-2">
                        <div x-data="{status : @entangle('status') }" class="btn-list">
                            <button class="btn btn-primary" x-show="status==='ab' || status==='pe' || status==='rp'"
                                    wire:click="play">
                                Play
                            </button>
                            <button class="btn btn-ghost-success" x-show="status==='co'"
                                    wire:click="reopen">
                                Reabrir
                            </button>
                            <button class="btn @if($status==='sc') btn-warning @else btn-success @endif"
                                    x-show="status==='ea' || status==='sc'"
                                    wire:click="conclude">
                                Concluir
                            </button>
                            @can('[DESPACHANTE] - Excluir Pedidos')
                                <button class="btn btn-danger" x-show="status!=='ex'" data-bs-toggle="modal"
                                        data-bs-target="#modal-delete">
                                    Excluir
                                </button>
                            @endcan
                        </div>
                    </div>
                    <x-delete-confirmation/>
                    <x-modal-aviso>
                        <div class="text-center">
                            <h3>Pedido Possui Pendências.</h3>
                            <div>Para prosseguir o pedido é necessário resolver as pendências.</div>
                        </div>
                    </x-modal-aviso>
                @endcan
                @cannot('[DESPACHANTE] - Acessar Sistema')
                    <div></div>
                @endcannot
            @endif
        </div>
    </div>
</div>
