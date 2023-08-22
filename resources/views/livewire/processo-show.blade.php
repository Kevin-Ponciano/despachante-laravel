<div>
    <div wire:loading>
        <x-loading-page/>
    </div>
    <x-page-title title="Processo" :subtitle="'Pedido: '.$pedido->numero_pedido" :status-display="$pedido->status()"
                  :status="$status" :responsavel="$pedido->usuarioResponsavel"
                  :concluido-por="$pedido->usuarioConcluinte"/>
    <div class="mt-2" x-data="{ isEditing: @entangle('isEditing'), status: @entangle('status'), inputRef: null }">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <ul wire:ignore class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-processo-info" class="nav-link active"
                               data-bs-toggle="tab" aria-selected="true" role="tab">Informações do Processo</a>
                        </li>
                        @if(Auth::user()->isDespachante())
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-pedido-info" class="nav-link" data-bs-toggle="tab"
                                   aria-selected="false" role="tab" tabindex="-1">Informações do Pedido</a>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-documentos" class="nav-link position-relative" data-bs-toggle="tab"
                               aria-selected="false" role="tab" tabindex="-1"
                               wire:click="getFilesLink">Documentos
                                <span x-show="status === 'pe'"
                                      class="badge bg-orange badge-notification badge-blink"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <form wire:submit.prevent="update" wire:ignore.self class="tab-pane active show"
                              id="tabs-processo-info" role="tabpanel">
                            @csrf
                            <div class="tab-content">
                                <x-processo>
                                    <x-slot:cliente>
                                        <label class="form-label text-muted">Cliente Logista</label>
                                        <p class="fw-bold h3">{{$cliente}}</p>
                                    </x-slot:cliente>
                                    <x-slot:nomeComprador>
                                        <label class="form-label">Nome do Comprador</label>
                                        <input type="text"
                                               class="form-control @error('compradorNome') is-invalid @enderror"
                                               wire:model.defer="compradorNome"
                                               x-ref="inputRef" x-init="$refs.inputRef = $el" :readonly="!isEditing">
                                        @error('compradorNome') <span
                                            class="invalid-feedback">{{ $message }}</span> @enderror
                                    </x-slot:nomeComprador>
                                    <x-slot:telefone>
                                        <label class="form-label">Telefone</label>
                                        <input type="text"
                                               class="form-control imask-telefone @error('telefone') is-invalid @enderror"
                                               wire:model.defer="telefone" :readonly="!isEditing">
                                        @error('telefone') <span
                                            class="invalid-feedback">{{ $message }}</span> @enderror
                                    </x-slot:telefone>
                                    <x-slot:placa>
                                        <label class="form-label">Placa</label>
                                        <input type="text"
                                               class="form-control text-uppercase @error('placa') is-invalid @enderror"
                                               maxlength="7"
                                               wire:model.defer="placa" :readonly="!isEditing">
                                        @error('placa') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </x-slot:placa>
                                    <x-slot:veiculo>
                                        <label class="form-label">Veículo</label>
                                        <input type="text" class="form-control @error('veiculo') is-invalid @enderror"
                                               wire:model.defer="veiculo" :readonly="!isEditing">
                                        @error('veiculo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </x-slot:veiculo>
                                    <x-slot:qtd_placa>
                                        <div class="form-label">Quantidade Placas:</div>
                                        <div x-data="{ qtdPlaca: @entangle('qtdPlaca') }">
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="qtd_placa_"
                                                       :checked="qtdPlaca === 0"
                                                       :disabled="!isEditing"
                                                       x-on:click="$wire.set('qtdPlaca',0)">
                                                <span class="form-check-label">0 Placas</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="qtd_placa_"
                                                       :checked="qtdPlaca === 1"
                                                       :disabled="!isEditing"
                                                       x-on:click="$wire.set('qtdPlaca',1)">
                                                <span class="form-check-label">1 Placas</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="qtd_placa_"
                                                       :checked="qtdPlaca === 2"
                                                       :disabled="!isEditing"
                                                       x-on:click="$wire.set('qtdPlaca',2)">
                                                <span class="form-check-label">2 Placas</span>
                                            </label>
                                        </div>
                                    </x-slot:qtd_placa>
                                    <x-slot:comprador_tipo>
                                        <div class="form-label">Comprador:</div>
                                        <div x-data="{ compradorTipo: @entangle('compradorTipo') }">
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="comprador_tipo_"
                                                       :checked="compradorTipo === 'tc'"
                                                       :disabled="!isEditing"
                                                       x-on:click="$wire.set('compradorTipo','tc')">
                                                <span class="form-check-label">Terceiro</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="comprador_tipo_"
                                                       :checked="compradorTipo === 'lj'"
                                                       :disabled="!isEditing"
                                                       x-on:click="$wire.set('compradorTipo','lj')">
                                                <span class="form-check-label">Loja</span>
                                            </label>
                                        </div>
                                    </x-slot:comprador_tipo>
                                    <x-slot:processo_tipo>
                                        <div class="form-label">Processo:</div>
                                        <div x-data="{ processoTipo: @entangle('processoTipo') }">
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="tipo_"
                                                       :checked="processoTipo === 'ss'"
                                                       :disabled="!isEditing"
                                                       x-on:click="$wire.set('processoTipo','ss')">
                                                <span class="form-check-label">Solicitação Serviço</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="tipo_"
                                                       :checked="processoTipo === 'rv'"
                                                       :disabled="!isEditing"
                                                       x-on:click="$wire.set('processoTipo','rv')">
                                                <span class="form-check-label">RENAV</span>
                                            </label>
                                        </div>
                                    </x-slot:processo_tipo>
                                    <x-slot:observacao>
                                        <div class="form-label">Observação</div>
                                        <textarea class="form-control" name="observacao" disabled
                                                  wire:model.defer="observacao"></textarea>
                                    </x-slot:observacao>
                                </x-processo>
                                <a class="btn btn-primary" x-show="!isEditing && status !== 'co' && status !== 'ex'"
                                   @click="isEditing = true; $nextTick(() => $refs.inputRef.focus())">
                                    Editar
                                </a>
                                <button class="btn btn-success" x-show="isEditing">
                                    Salvar
                                </button>
                            </div>
                        </form>
                        @if(Auth::user()->isDespachante())
                            <div wire:ignore.self class="tab-pane" id="tabs-pedido-info" role="tabpanel">
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <div class="d-flex gap-2">
                                                    <label class="form-label">Valor Placas</label>
                                                    <x-action-message on="savedPrecoPlaca">
                                                        Atualizado.
                                                    </x-action-message>
                                                </div>
                                                <div class="input-icon">
                                                    <span class="input-icon-addon">
                                                        <i class="ti ti-currency-real"></i>
                                                    </span>
                                                    <input x-data x-mask:dynamic="$money($input, ',','.')"
                                                           type="text" class="form-control px-5 w-50"
                                                           wire:model.defer="precoPlaca" wire:change="savePrecoPlaca">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <div class="d-flex gap-2">
                                                    <label class="form-label">Valor Honorário</label>
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
                                    <div class="form-fieldset row">
                                        <div class="d-flex gap-2">
                                            <h4>Serviços</h4>
                                            <x-action-message class="ms-2" on="savedPriceServico">
                                                Salvo.
                                            </x-action-message>
                                        </div>
                                        @foreach($servicos as $index => $servico)
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Valor {{$servico['nome']}}</label>
                                                    <div class="input-icon w-66">
                                                    <span class="input-icon-addon">
                                                        <i class="ti ti-currency-real"></i>
                                                    </span>
                                                        <input x-data x-mask:dynamic="$money($input, ',','.')"
                                                               type="text" class="form-control px-5"
                                                               wire:model.defer="servicos.{{ $index }}.preco"
                                                               wire:change="savePriceServico({{$index}})">
                                                        <a class="btn btn-danger btn-remove-service px-0 py-0 rounded-5"
                                                           title="Remover Serviço"
                                                           wire:click="removeServico({{$servico['id']}})">
                                                            <i class="ti ti-minus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div>
                                            <select class="form-select mb-2 w-33" wire:model.defer="servicoId">
                                                <option value="-1" selected>Selecionar Serviço</option>
                                                @foreach($servicosDespachante as $servico)
                                                    <option title="{{$servico->descricao}}"
                                                            value="{{$servico->id}}">{{$servico->nome}} </option>
                                                @endforeach
                                            </select>
                                            <a class="btn btn-ghost-primary" wire:click="addServico">Adicionar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div wire:ignore.self class="tab-pane" id="tabs-documentos" role="tabpanel">
                            <x-accordion id="accordion-docs" :active="true"
                                         class="h3 mb-0">
                                <x-slot:title>
                                    Documentos Do Pedido
                                    <x-helper>
                                        <p>Documentos Enviados pelo Cliente</p>
                                        <p>Durante a solicitação do serviço.</p>
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
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <x-input-upload-files uploadMethod="uploadFiles" folder="processos"
                                                                  label="Enviar Documentos para baixa"/>
                                        </div>
                                    </div>
                                </x-slot:body>
                            </x-accordion>
                            <!-- TODO Adicionar opcoes para baixar todos os arquivos em um zip -->
                            <div class="row gap-5 px-2 mt-2">
                                <fieldset class="col form-fieldset">
                                    <div class="h3">Código de Segurança/CRLV
                                        <x-helper>
                                            <h4>Documentos a serem baixados pelo Cliente</h4>
                                        </x-helper>
                                    </div>
                                    <div class="row row-deck row-cards mb-2">
                                        @forelse($arquivosCodCrlv as $arquivoCc)
                                            <x-file :nome="$arquivoCc['name']"
                                                    :link="$arquivoCc['link']"
                                                    :timestamp="$arquivoCc['timestamp']"
                                                    :path="$arquivoCc['path']"
                                                    col="col"/>
                                        @empty
                                            <div>
                                                <div class="text-center text-muted">
                                                    Nenhum Documento Enviado.
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <form wire:submit.prevent="uploadCodCrlv">
                                        <div class="w-66">
                                            <x-input-upload label="Código Segurança" prop-name="arquivoCodSeg"
                                                            upload-method="uploadCodCrlv"/>
                                        </div>
                                        <div class="w-66">
                                            <x-input-upload label="CRLV" prop-name="arquivoCrlv"
                                                            upload-method="uploadCodCrlv"/>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            Enviar
                                        </button>
                                    </form>
                                </fieldset>
                                <fieldset class="col form-fieldset py-1">
                                    <div class="h3 fw-bolder text-warning-emphasis">
                                        Pendências
                                        <i class="badge bg-warning badge-blink ms-1 p-1"></i>
                                    </div>
                                    <div class="pt-0">
                                        <strong>This is the second item's accordion body.</strong> It is hidden by
                                        default, until the collapse plugin adds the appropriate classes that we use
                                        to style each element. These classes control the overall appearance, as well
                                        as the showing and hiding via CSS transitions. You can modify any of this
                                        with custom CSS or overriding our default variables. It's also worth noting
                                        that just about any HTML can go within the <code>.accordion-body</code>,
                                        though the transition does limit overflow.
                                    </div>
                                    <button class="btn btn-ghost-warning">
                                        <i class="ti ti-alert-triangle px-2"></i>
                                        Remover Pendência
                                    </button>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-delete-file" tabindex="-1" style="display: none;"
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
                    <h2>Tem certeza?</h2>
                    <h3 id="file-name-delete"></h3>
                    <div class="text-muted">Ao deletar o arquivo não será mais possível recuperar.</div>
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
                                <a href="#" class="btn btn-danger w-100"
                                   onclick="$(window).trigger('deleteFileConfirm')">
                                    Deletar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
