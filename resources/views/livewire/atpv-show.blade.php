<div>
    <x-page-title title="ATPV" :subtitle="'Pedido: '.$atpv->pedido_id">
        <x-slot name="actions">
            <div x-data="{status : $wire.status }" class="btn-list">
                <button class="btn">
                    Imprimir
                </button>
                <button class="btn btn-warning" x-show="status!=='ex' && status!=='cd'">
                    Dados Incorretos
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
        </x-slot>
    </x-page-title>
    <div class="mt-2">
        <div class="container">
            <div class="card">
                <div class="card-header d-print-none">
                    <ul wire:ignore class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-atpv-info" class="nav-link active"
                               data-bs-toggle="tab" aria-selected="true" role="tab">Informações do ATPV</a>
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
                <div class="card-body" id="print">
                    <div class="tab-content">
                        <div wire:ignore.self class="tab-pane active show" id="tabs-atpv-info" role="tabpanel">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label">Cliente Logista</label>
                                            <selec class="form-control">
                                                <option disabled selected>Selecionar Cliente</option>
                                            </selec>
                                        </div>
                                    </div>
                                </div>
                                <fieldset class="form-fieldset">
                                    <h4>Informações do Veículo</h4>
                                    <div class="row">
                                        <div class="col-{{$col_length}}">
                                            <div class="mb-3">
                                                <label class="form-label">Placa</label>
                                                <input type="text" class="form-control text-uppercase" readonly
                                                       maxlength="7" name="placa" wire:model.defer="placa">
                                            </div>
                                        </div>
                                        <div class="col-{{$col_length}}">
                                            <div class="mb-3">
                                                <label class="form-label">Renavan</label>
                                                <input x-data x-mask:dynamic="alpineMaskNumero11" readonly
                                                       type="text" class="form-control" name="renavan"
                                                       wire:model.defer="renavan">
                                            </div>
                                        </div>
                                        <div class="col-{{$col_length}}">
                                            <div class="mb-3">
                                                <label class="form-label">Número CRV</label>
                                                <input x-data x-mask:dynamic="alpineMaskNumero12" readonly
                                                       type="text" class="form-control" name="numeroCrv"
                                                       wire:model.defer="numeroCrv">
                                            </div>
                                        </div>
                                        @if($isRenave)
                                            <div class="col-{{$col_length}}">
                                                <div class="mb-3">
                                                    <label class="form-label">Código Segurança CRV</label>
                                                    <input x-data x-mask:dynamic="alpineMaskNumero12" readonly
                                                           type="text" class="form-control" name="codigoCrv"
                                                           wire:model.defer="codigoCrv">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Hodômetro</label>
                                                <div class="input-icon">
                                                    <input x-data x-mask:dynamic="alpineMaskNumero" readonly
                                                           type="text" class="form-control" name="hodometro"
                                                           wire:model.defer="hodometro">
                                                    <span class="input-icon-addon fw-bold">
                                                            KM
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Data Hora Medição</label>
                                                <input type="datetime-local" class="form-control" name="dataHodometro"
                                                       readonly
                                                       wire:model.defer="horaHodometro">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Valor de Venda</label>
                                                <div class="input-icon">
                                                    <span class="input-icon-addon">
                                                        <i class="ti ti-currency-real"></i>
                                                    </span>
                                                    <input x-data x-mask:dynamic="$money($input, '.','')" readonly
                                                           type="text" class="form-control"
                                                           name="precoVenda" wire:model.defer="precoVenda">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="mb-3">
                                                <label class="form-label">Veículo</label>
                                                <input type="text" class="form-control" name="veiculo" readonly
                                                       wire:model.defer="veiculo">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-fieldset">
                                    <h4>Informações do Vendedor</h4>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">E-mail</label>
                                                <input type="email" class="form-control" name="vendedorEmail" readonly
                                                       wire:model.defer="vendedorEmail">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Telefone</label>
                                                <input readonly
                                                       type="text" class="form-control imask-telefone"
                                                       name="vendedorTelefone"
                                                       wire:model.defer="vendedorTelefone">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">CPF/CNPJ</label>
                                                <input type="text" class="form-control imask-cpf-cnpj" readonly
                                                       name="vendedorCpfCnpj"
                                                       wire:model.defer="vendedorCpfCnpj">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-fieldset">
                                    <h4>Informações do Comprador</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nome</label>
                                                <input type="email" class="form-control" name="compradorNome" readonly
                                                       wire:model.defer="compradorNome">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">E-mail</label>
                                                <input type="email" class="form-control" name="compradorEmail" readonly
                                                       wire:model.defer="compradorEmail">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Telefone</label>
                                                <input readonly
                                                       type="text" class="form-control imask-telefone"
                                                       name="compradorTelefone"
                                                       wire:model.defer="compradorTelefone">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">CPF/CNPJ</label>
                                                <input type="text" class="form-control imask-cpf-cnpj" readonly
                                                       name="compradorCpfCnpj"
                                                       wire:model.defer="compradorCpfCnpj">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label">CEP</label>
                                                <input x-data x-mask:dynamic="alpineMaskCep" readonly
                                                       type="text" class="form-control" name="cep"
                                                       wire:model.defer="cep">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="mb-3">
                                                <label class="form-label">Logradouro</label>
                                                <input type="text" class="form-control" name="logradouro" readonly
                                                       wire:model.defer="logradouro">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="mb-3">
                                                <label class="form-label">Número</label>
                                                <input x-data x-mask:dynamic="alpineMaskNumero" readonly
                                                       type="text" class="form-control" name="numero"
                                                       wire:model.defer="numero">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Bairro</label>
                                                <input type="text" class="form-control" name="bairro" readonly
                                                       wire:model.defer="bairro">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="mb-3">
                                                <label class="form-label">Município</label>
                                                <input type="text" class="form-control" name="municipio" readonly
                                                       wire:model.defer="municipio">
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="mb-3">
                                                <label class="form-label">UF</label>
                                                <input x-data x-mask:dynamic="alpineMaskUf" readonly
                                                       type="text" class="form-control text-uppercase px-2"
                                                       name="uf"
                                                       wire:model.defer="uf">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label class="form-label">Observação</label>
                                        <textarea class="form-control" name="observacao"
                                                  wire:model.defer="observacao"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div wire:ignore.self class="tab-pane" id="tabs-pedido-info" role="tabpanel">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label">Valor Honorário ATPV</label>
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-currency-real"></i>
                                                </span>
                                                <input type="text" class="form-control imask-preco px-5 w-50"
                                                       wire:model.defer="preco_honorario">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($servicos))
                                    <div class="form-fieldset row">
                                        <h4>Serviços</h4>
                                        @foreach($servicos as $index => $servico)
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Valor {{$servico['nome']}}</label>
                                                    <div class="input-icon w-66">
                                                    <span class="input-icon-addon">
                                                        <i class="ti ti-currency-real"></i>
                                                    </span>
                                                        <input x-data x-mask:dynamic="$money($input, '.','')"
                                                               type="text" class="form-control px-5"
                                                               wire:model.defer="servicos.{{ $index }}.preco">
                                                        <button
                                                            class="btn btn-ghost-danger btn-remove-service px-0 py-0"
                                                            title="Remover Serviço"
                                                            wire:click="removeServico({{$servico['id']}})">
                                                            <i class="ti ti-square-rounded-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <button class="btn btn-success mt-2">
                                Salvar
                            </button>
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
                </div>
            </div>
        </div>
    </div>
</div>
