<div>
    <x-page-title title="Processo" :subtitle="'Pedido: '.$pedido->id">
        <x-slot:actions>
            <div x-data="{status : $wire.status }" class="btn-list">
                <button class="btn">
                    Imprimir
                </button>
                <button class="btn btn-success" x-show="status==='ab'">
                    Play
                </button>
                <button class="btn btn-success" x-show="status==='ea'">
                    Concluir
                </button>
                <button class="btn btn-danger" x-show="status!=='ex'">
                    Excluir
                </button>
            </div>
        </x-slot:actions>
    </x-page-title>
    <div class="mt-2">
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
                            <a href="#tabs-documentos" class="nav-link" data-bs-toggle="tab"
                               aria-selected="false" role="tab" tabindex="-1">Documentos</a>
                        </li>
                    </ul>
                </div>
                <form class="card-body" wire:submit.prevent="update">
                    @csrf
                    <div class="tab-content">
                        <div wire:ignore.self class="tab-pane active show" id="tabs-processo-info" role="tabpanel">
                            <div class="tab-content" x-data="{ isEditing: @entangle('isEditing'), inputRef: null }">
                                <x-processo>
                                    <x-slot:cliente>
                                        <label class="form-label text-muted">Cliente Logista</label>
                                        <p class="fw-bold h3">{{$cliente}}</p>
                                    </x-slot:cliente>
                                    <x-slot:nomeComprador>
                                        <label class="form-label">Nome do Comprador</label>
                                        <input type="text"
                                               class="form-control @error('compradorNome') is-invalid @enderror"
                                               wire:model.defer="compradorNome" :readonly="!isEditing"
                                               x-ref="inputRef"
                                               x-init="$refs.inputRef = $el">
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
                                <a class="btn btn-primary" x-show="!isEditing"
                                   @click="isEditing = true; $nextTick(() => $refs.inputRef.focus())">
                                    Editar
                                </a>
                                <button class="btn btn-success" x-show="isEditing">
                                    Salvar
                                </button>
                            </div>
                        </div>
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
                                                {{--                        todo: Aplicar com relacionamentos--}}
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
                            Documentos
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
