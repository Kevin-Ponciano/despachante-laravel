<div>
    <x-page-title title="Processo" :subtitle="'Pedido: '.$pedido->numero_pedido" :status-display="$pedido->status()"
                  :status="$status" :responsavel="$pedido->usuarioResponsavel"
                  :concluido-por="$pedido->usuarioConcluinte" :concluido-em="$pedido->concluido_em()"/>
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
                                   aria-selected="false" role="tab" tabindex="-1">Valores/Serviços</a>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-documentos" class="nav-link position-relative" data-bs-toggle="tab"
                               aria-selected="false" role="tab" tabindex="-1">Documentos
                                <span x-show="status === 'pe'"
                                      class="badge bg-orange badge-notification badge-blink"></span>
                            </a>
                        </li>
                        <li class="nav-item ms-auto" role="presentation">
                            <a data-bs-toggle="offcanvas" href="#offcanvas" class="nav-link"
                               aria-controls="offcanvasEnd">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-history-toggle" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969"></path>
                                    <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554"></path>
                                    <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592"></path>
                                    <path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305"></path>
                                    <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356"></path>
                                    <path d="M12 8v4l3 3"></path>
                                </svg>
                                Atividades do Pedido
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
                                <x-processo :servicos="$servicos" :tipo-processo="$processoTipo">
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
                                                <span class="form-check-label">RENAVE</span>
                                            </label>
                                        </div>
                                    </x-slot:processo_tipo>
                                    <x-slot:observacao>
                                        <div class="form-label">Observação</div>
                                        <textarea class="form-control" name="observacao" disabled
                                                  wire:model.defer="observacao"></textarea>
                                    </x-slot:observacao>
                                </x-processo>
                                @if(Auth::user()->isDespachante())
                                    <a class="btn btn-primary" x-show="!isEditing && status !== 'co' && status !== 'ex'"
                                       @click="isEditing = true; $nextTick(() => $refs.inputRef.focus())">
                                        Editar
                                    </a>
                                    <button class="btn btn-success" x-show="isEditing">
                                        Salvar
                                    </button>
                                @endif
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
                                    @if(Auth::user()->isDespachante())
                                        <x-helper>
                                            <p>Documentos Enviados pelo Cliente</p>
                                            <p>Durante a solicitação do serviço.</p>
                                        </x-helper>
                                    @endif
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
                                                    Nenhum documento enviado.
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    @if((Auth::user()->isCliente() && $status === 'pe') || Auth::user()->isDespachante())
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <x-input-upload-files :arquivos="$arquivosDoPedido"
                                                                      uploadMethod="uploadFiles" folder="processos"
                                                                      label="Enviar Documentos (somente PDF's)"/>
                                            </div>
                                        </div>
                                    @endif
                                </x-slot:body>
                            </x-accordion>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <fieldset class="form-fieldset">
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
                                                        @if(Auth::user()->isDespachante())
                                                            Nenhum documento enviado.
                                                        @else
                                                            Nenhum documento disponível para download.
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                        @if(Auth::user()->isDespachante())
                                            <form wire:submit.prevent="uploadCodCrlv">
                                                <div>
                                                    <x-input-upload label="Código Segurança" prop-name="arquivoCodSeg"
                                                                    upload-method="uploadCodCrlv"/>
                                                </div>
                                                <div>
                                                    <x-input-upload label="CRLV" prop-name="arquivoCrlv"
                                                                    upload-method="uploadCodCrlv"/>
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    Enviar
                                                </button>
                                            </form>
                                        @endif
                                    </fieldset>
                                </div>
                                <div class="col">
                                    <livewire:pendencias/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-delete-file-confirm/>
    @if(Auth::user()->isCliente())
        <x-modal-sucesso id="modal-sucesso-documento" title="Documentos Enviados com Sucesso"
                         description="Os documentos foram enviados com sucesso. Eles serão analisados e se estiverem corretos daremos continuidade ao processo."
                         url="{{route('cliente.dashboard')}}"/>
    @endif
    <x-offcanvas direction="end" title="Atividades do Pedido">
        <x-timeline :timelines="$pedido->timelines()->orderByDesc('created_at')->get()"/>
    </x-offcanvas>
</div>
