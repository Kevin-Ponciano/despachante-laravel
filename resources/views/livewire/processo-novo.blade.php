<div>
    <ul wire:ignore class="nav nav-tabs card-header-tabs flex-row-reverse m-0" data-bs-toglgle="tabs">
        <li class="nav-item" role="presentation" wire:click="setPrecos">
            <a href="#tabs-info-pedido" class="nav-link"
               data-bs-toggle="tab"
               aria-selected="false"
               role="tab"
               tabindex="-1">Informações Pedido</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#tabs-processo2" class="nav-link active"
               data-bs-toggle="tab"
               aria-selected="true"
               role="tab">Informações Processo</a>
        </li>
    </ul>
    <form wire:submit.prevent="store"
          x-data="{ isUploading: false, error: false,input: $('#uploadFile') }"
          x-on:livewire-upload-start="isUploading = true"
          x-on:livewire-upload-finish="isUploading = false;input.addClass('is-valid')"
          x-on:livewire-upload-error="error = true"
          x-on:livewire-upload-progress="input.removeClass('is-invalid');input.removeClass('is-valid')">
        @csrf
        <div class="tab-content p-3">
            <div wire:ignore.self class="tab-pane active show" id="tabs-processo2" role="tabpanel">
                <x-processo>
                    <x-slot:cliente>
                        <label class="form-label">Cliente Logista</label>
                        <div wire:ignore>
                            <select id="select-cliente-processo-novo"
                                    class="form-control"
                                    wire:model.defer="clienteId">
                                <option value="-1">Selecione o Cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="is-invalid"></div>
                        @error('clienteId')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </x-slot:cliente>
                    <x-slot:nomeComprador>
                        <label class="form-label">Nome do Comprador</label>
                        <input type="text" class="form-control @error('compradorNome') is-invalid @enderror"
                               wire:model.defer="compradorNome">
                        @error('compradorNome') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </x-slot:nomeComprador>
                    <x-slot:telefone>
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control imask-telefone @error('telefone') is-invalid @enderror"
                               wire:model.defer="telefone">
                        @error('telefone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </x-slot:telefone>
                    <x-slot:placa>
                        <label class="form-label">Placa</label>
                        <input type="text" class="form-control text-uppercase @error('placa') is-invalid @enderror"
                               maxlength="7"
                               wire:model.defer="placa">
                        @error('placa') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </x-slot:placa>
                    <x-slot:veiculo>
                        <label class="form-label">Veículo</label>
                        <input type="text" class="form-control @error('veiculo') is-invalid @enderror"
                               wire:model.defer="veiculo">
                        @error('veiculo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </x-slot:veiculo>
                    <x-slot:qtd_placa>
                        <div class="form-label">Quantidade Placas:</div>
                        <div>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="qtdPlacas" value="0" checked
                                       wire:model.defer="qtdPlacas">
                                <span class="form-check-label">0 Placas</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="qtdPlacas" value="1"
                                       wire:model.defer="qtdPlacas">
                                <span class="form-check-label">1 Placas</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="qtdPlacas" value="2"
                                       wire:model.defer="qtdPlacas">
                                <span class="form-check-label">2 Placas</span>
                            </label>
                        </div>
                    </x-slot:qtd_placa>
                    <x-slot:comprador_tipo>
                        <div class="form-label">Comprador:</div>
                        <div>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" checked name="compradorTipo" value="tc"
                                       wire:model.defer="compradorTipo">
                                <span class="form-check-label">Terceiro</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="compradorTipo" value="lj"
                                       wire:model.defer="compradorTipo">
                                <span class="form-check-label">Loja</span>
                            </label>
                        </div>
                    </x-slot:comprador_tipo>
                    <x-slot:processo_tipo>
                        <div class="form-label">Processo:</div>
                        <div>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" checked name="processoTipo" value="ss"
                                       wire:model.defer="processoTipo">
                                <span class="form-check-label">Solicitação Serviço</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="processoTipo" value="rv"
                                       wire:model.defer="processoTipo">
                                <span class="form-check-label">RENAV</span>
                            </label>
                        </div>
                    </x-slot:processo_tipo>
                    <x-slot:observacao>
                        <div class="form-label">Observação <span class="text-muted">opcional</span></div>
                        <textarea class="form-control" name="observacoes" wire:model.defer="observacoes"></textarea>
                    </x-slot:observacao>
                </x-processo>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <div class="form-label">Enviar Documentos .pdf</div>
                            <div class="input-icon">
                                <input :disabled="isUploading"
                                       class="form-control @error('arquivos.*') is-invalid @enderror"
                                       id="uploadFile" type="file" accept="application/pdf" multiple
                                       wire:model="arquivos">
                                @error('arquivos.*') <span x-show="!isUploading"
                                                           class="invalid-feedback">{{ $message }}</span> @enderror
                                <span x-show="isUploading" class="input-icon-addon">
                                        <div class="spinner-border spinner-border-sm text-muted" role="status"></div>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div wire:ignore.self class="tab-pane" id="tabs-info-pedido" role="tabpanel">
                <h4>Informação do Pedido</h4>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Valor Placas</label>
                            <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="ti ti-currency-real"></i>
                            </span>
                                <input x-mask:dynamic="$money($input, ',','.')"
                                       type="text" class="form-control px-5 w-66"
                                       wire:model.defer="precoPlaca">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Valor Honorário</label>
                            <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="ti ti-currency-real"></i>
                            </span>
                                <input x-mask:dynamic="$money($input, ',','.')"
                                       type="text" class="form-control px-5 w-66"
                                       wire:model.defer="precoHonorario">
                            </div>
                        </div>
                    </div>
                    <h4>Serviços</h4>
                    @foreach($servicos as $index => $servico)
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Valor {{$servico['nome']}}</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>
                                    <input x-mask:dynamic="$money($input, ',','.')"
                                           type="text" class="form-control px-5"
                                           wire:model.defer="servicos.{{ $index }}.preco">
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
        <div class="modal-footer p-3">
            <a href="#" wire:click="clearInputs" class="btn btn-link link-secondary"
               data-bs-dismiss="modal">
                Cancelar
            </a>
            <button :disabled="isUploading" type="submit" class="btn btn-primary ms-auto">
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
    </form>
</div>
