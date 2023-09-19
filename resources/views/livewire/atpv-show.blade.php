<div>
    <div wire:loading wire:target="downloadFile, downloadAllFiles">
        <x-loading-page/>
    </div>
    <!-- TODO: Imposibilitar edição das informações do Pedido -->
    <x-page-title :title="$tipo" :subtitle="'Pedido: '.$pedido->numero_pedido" :status-display="$pedido->status()"
                  :status="$status" :responsavel="$pedido->usuarioResponsavel"
                  :concluido-por="$pedido->usuarioConcluinte"/>
    <div class="mt-2">
        <div class="container">
            <div class="card">
                <div class="card-header d-print-none">
                    <ul wire:ignore class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-atpv-info" class="nav-link active"
                               data-bs-toggle="tab" aria-selected="true" role="tab">Informações
                                do {{$tipo}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-pedido-info" class="nav-link" data-bs-toggle="tab"
                               aria-selected="false" role="tab" tabindex="-1">Valores/Serviços</a>
                            <!-- TODO: Ocultar para o cliente-->
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-documentos" class="nav-link" data-bs-toggle="tab"
                               aria-selected="false" role="tab" tabindex="-1"
                            >Documentos</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div wire:ignore.self class="tab-pane active show" id="tabs-atpv-info" role="tabpanel">
                            <form wire:submit.prevent="update">
                                <!-- TODO: Verificar pq ao dar enter buga o submit -->
                                @csrf
                                <div class="tab-content"
                                     x-data="{ isEditing: @entangle('isEditing'), status: @entangle('status'), inputRef: null, checkPendencia: false }">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex justify-content-between gap-8">
                                            <div>
                                                <label class="form-label text-muted">Cliente Logista</label>
                                                <p class="fw-bold h3">{{$cliente}}</p>
                                            </div>
                                            @if($isRenave)
                                                <div>
                                                    <label class="form-label text-muted">Movimentação Renave</label>
                                                    <p class="fw-bold h3">{{$movimentacao}}</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="my-auto">
                                            <livewire:pendencias :is-modal="true"/>
                                        </div>
                                    </div>
                                    <x-atpv-form :is-renave="$isRenave"
                                                 :obs="true"
                                                 :atpv-show="true"
                                    />
                                    <div class="mt-3 btn-list">
                                        <a class="btn btn-primary"
                                           x-show="!isEditing && status !== 'co' && status !== 'ex'"
                                           @click="isEditing = true;$nextTick(() => $refs.inputRef.focus())">
                                            Editar
                                        </a>
                                        <button class="btn btn-success" x-show="isEditing">
                                            Salvar
                                        </button>
                                        <a class="btn btn-danger" x-show="isEditing || checkPendencia"
                                           x-on:click="isEditing = false;checkPendencia = false">
                                            Cancelar
                                        </a>
                                        <a class="btn btn-warning" x-show="checkPendencia"
                                           x-on:click="checkPendencia = false" wire:click="storeInputPendencias">
                                            Salvar Campos Incorretos
                                        </a>
                                        <a class="btn btn-warning" x-show="!checkPendencia"
                                           x-on:click="checkPendencia = true; window.location.href='#'">
                                            Informar Campos Incorretos
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div wire:ignore.self class="tab-pane" id="tabs-pedido-info" role="tabpanel">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <div class="d-flex gap-2">
                                                <label class="form-label">Valor Honorário {{$tipo}}</label>
                                                <x-action-message on="savedPrecoHonorario">
                                                    Atualizado.
                                                </x-action-message>
                                            </div>
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-currency-real"></i>
                                                </span>
                                                <input x-data x-mask:dynamic="$money($input, ',','.')"
                                                       type="text" class="form-control px-5 w-50"
                                                       wire:model.defer="precoHonorario"
                                                       wire:change="savePrecoHonorario">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div wire:ignore.self class="tab-pane" id="tabs-documentos" role="tabpanel">
                            @if($isRenave)
                                <x-accordion id="accordion-docs" :active="true"
                                             class="h3 mb-0">
                                    <x-slot:title>
                                        Documentos do RENAVE (Pedido)
                                        <x-helper>
                                            <p>Documentos Enviados pelo Cliente</p>
                                            <p>Durante a abertura do Renave para a Transferência.</p>
                                        </x-helper>
                                    </x-slot:title>
                                    <x-slot:body>
                                        <div class="row row-deck row-cards mb-2">
                                            @forelse($arquivosDoPedido as $arquivoPedido)
                                                <x-file :nome="$arquivoPedido['name']"
                                                        :link="$arquivoPedido['link']"
                                                        :timestamp="$arquivoPedido['timestamp']"
                                                        :path="$arquivoPedido['path']"/>

                                            @empty
                                                <div>
                                                    <div class="text-center text-muted">
                                                        Nenhum documento enviado pelo cliente.
                                                    </div>
                                                </div>

                                            @endforelse
                                        </div>
                                        @if($status === 'pe')
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <x-input-upload-files uploadMethod="uploadFiles"
                                                                          folder="renave/despachante"
                                                                          label="Enviar Documentos para baixa"/>
                                                </div>
                                            </div>
                                        @endif
                                    </x-slot:body>
                                </x-accordion>
                                <div class="row mt-2">
                                    <div class="col-12 mt-2">
                                        <fieldset class="form-fieldset">
                                            <div class="h3">Documentos do RENAVE (Cliente)
                                                <x-helper>
                                                    <h4>Documentos a serem enviados e baixados pelo Cliente</h4>
                                                </x-helper>
                                            </div>
                                            <div class="row row-deck row-cards mb-2">
                                                @forelse($arquivosRenave as $arquivoRenave)
                                                    <x-file :nome="$arquivoRenave['name']"
                                                            :link="$arquivoRenave['link']"
                                                            :timestamp="$arquivoRenave['timestamp']"
                                                            :path="$arquivoRenave['path']"
                                                            col="col"/>
                                                @empty
                                                    <div>
                                                        <div class="text-center text-muted">
                                                            Nenhum Documento Enviado.
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <x-input-upload-files uploadMethod="uploadFiles"
                                                                          folder="renave/cliente"
                                                                          label="Enviar Documentos para baixa"/>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @else
                                <div class="row mt-2">
                                    <div class="col-5">
                                        <fieldset class="form-fieldset">
                                            <div class="h3">Documentos do {{$tipo}}
                                                <x-helper>
                                                    <h4>Documentos a serem baixados pelo Cliente</h4>
                                                </x-helper>
                                            </div>
                                            <div class="row row-deck row-cards mb-2">
                                                @forelse($arquivosAtpvs as $arquivoAtpv)
                                                    <x-file :nome="$arquivoAtpv['name']"
                                                            :link="$arquivoAtpv['link']"
                                                            :timestamp="$arquivoAtpv['timestamp']"
                                                            :path="$arquivoAtpv['path']"
                                                            col="col"/>
                                                @empty
                                                    <div>
                                                        <div class="text-center text-muted">
                                                            Nenhum Documento Enviado.
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <form wire:submit.prevent="uploadAtpv">
                                                <div>
                                                    <x-input-upload label="Documento ATPV" prop-name="arquivoAtpv"
                                                                    upload-method="uploadAtpv"/>
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    Enviar
                                                </button>
                                            </form>
                                        </fieldset>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-delete-file-confirm/>
</div>
