<div>
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
                               aria-selected="false" role="tab" tabindex="-1">Informações do Pedido</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-documentos" class="nav-link" data-bs-toggle="tab"
                               aria-selected="false" role="tab" tabindex="-1">Documentos</a>
                        </li>
                    </ul>
                </div>
                <form class="card-body" wire:submit.prevent="update">
                    @csrf
                    <div class="tab-content">
                        <div wire:ignore.self class="tab-pane active show" id="tabs-atpv-info" role="tabpanel">
                            <div class="tab-content"
                                 x-data="{ isEditing: @entangle('isEditing'), status: @entangle('status'), inputRef: null }">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Cliente Logista</label>
                                            <p class="fw-bold h3">{{$cliente}}</p>
                                        </div>
                                    </div>
                                </div>
                                <x-atpv-form :is-renave="$isRenave"
                                             :obs="true"
                                />
                                <div class="mt-3">
                                    <a class="btn btn-primary" x-show="!isEditing && status !== 'co' && status !== 'ex'"
                                       @click="isEditing = true;$nextTick(() => $refs.inputRef.focus())">
                                        Editar
                                    </a>
                                    <button class="btn btn-success" x-show="isEditing">
                                        Salvar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div wire:ignore.self class="tab-pane" id="tabs-pedido-info" role="tabpanel">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <div class="d-flex gap-2">
                                                <label class="form-label">Valor Honorário ATPV</label>
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <div class="form-label">Enviar documento ATPV:</div>
                                        <input type="file" class="form-control" accept="application/pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
