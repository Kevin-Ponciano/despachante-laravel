@php
    use App\Models\Servico;
@endphp
<div>
    <ul wire:ignore class="nav nav-tabs card-header-tabs flex-row-reverse" data-bs-toglgle="tabs">
        <li class="nav-item" role="presentation">
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

    <div class="tab-content">
        <div wire:ignore.self class="tab-pane active show" id="tabs-processo2" role="tabpanel">
            <x-processo>
                <x-slot:cliente>
                    <label class="form-label">Cliente Logista</label>
                    <selec class="form-control">
                        <option disabled selected>Selecionar Cliente</option>
                    </selec>
                </x-slot:cliente>
                <x-slot:nomeComprador>
                    <label class="form-label">Nome do Comprador</label>
                    <input type="text" class="form-control" name="nome" wire:model.defer="nome">
                </x-slot:nomeComprador>
                <x-slot:telefone>
                    <label class="form-label">Telefone</label>
                    <input type="text" class="form-control imask-telefone" name="telefone"
                           wire:model.defer="telefone">
                </x-slot:telefone>
                <x-slot:placa>
                    <label class="form-label">Placa</label>
                    <input type="text" class="form-control text-uppercase" maxlength="7" name="placa"
                           wire:model.defer="placa">
                </x-slot:placa>
                <x-slot:veiculo>
                    <label class="form-label">Veículo</label>
                    <input type="text" class="form-control" name="veiculo" wire:model.defer="veiculo">
                </x-slot:veiculo>
                <x-slot:qtd_placa>
                    <div class="form-label">Quantidade Placas:</div>
                    <div>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="qtd_placa" checked>
                            <span class="form-check-label">0 Placas</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="qtd_placa">
                            <span class="form-check-label">1 Placas</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="qtd_placa">
                            <span class="form-check-label">2 Placas</span>
                        </label>
                    </div>
                </x-slot:qtd_placa>
                <x-slot:comprador_tipo>
                    <div class="form-label">Comprador:</div>
                    <div>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="comprador_tipo" checked>
                            <span class="form-check-label">Terceiro</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="comprador_tipo">
                            <span class="form-check-label">Loja</span>
                        </label>
                    </div>
                </x-slot:comprador_tipo>
                <x-slot:processo_tipo>
                    <div class="form-label">Processo:</div>
                    <div>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" checked>
                            <span class="form-check-label">Solicitação Serviço</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="tipo">
                            <span class="form-check-label">RENAV</span>
                        </label>
                    </div>
                </x-slot:processo_tipo>
                <x-slot:observacao>
                    <div class="form-label">Observação</div>
                    <textarea class="form-control" name="observacao" wire:model.defer="observacao"></textarea>
                </x-slot:observacao>
            </x-processo>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <div class="form-label">Enviar Documentos .pdf</div>
                        <input type="file" class="form-control" multiple accept="application/pdf">
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
                            <input type="text" class="form-control imask-preco px-5 w-66"
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
                            <input type="text" class="form-control imask-preco px-5 w-66"
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
                                <input x-data x-mask:dynamic="$money($input, '.','')"
                                       type="text" class="form-control px-5"
                                       wire:model.defer="servicos.{{ $index }}.preco">
                                <button class="btn btn-ghost-danger btn-remove-service px-0 py-0"
                                        title="Remover Serviço"
                                        wire:click="removeServico({{$servico['id']}})">
                                    <i class="ti ti-square-rounded-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div>
                    <select class="form-select mb-2 w-33" wire:model.defer="servicoId">
                        <option value="-1" selected>Selecionar Serviço</option>
                        {{--                        todo: Aplicar com relacionamentos--}}
                        @foreach(Servico::all() as $servico)
                            <option title="{{$servico->descricao}}"
                                    value="{{$servico->id}}">{{$servico->nome}} </option>
                        @endforeach
                    </select>
                    <button class="btn btn-ghost-primary" wire:click="addServico">Adicionar</button>
                </div>
            </div>
        </div>
    </div>
</div>

