<div>
    <div class="d-flex justify-content-between">
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Cliente Logista</label>
                <selec class="form-control">
                    <option disabled selected>Selecionar Cliente</option>
                </selec>
            </div>
        </div>
        <div class="row g-2 mb-3">
            <div class="col">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox"
                            wire:click="renaveSwitch">
                    <span class="form-check-label">RENAVE</span>
                </label>
            </div>
            <div class="col-auto">
              <span class="form-help" data-bs-toggle="popover" data-bs-placement="top"
                    data-bs-content=
                        "<p>Será adicionado um campo para o Código de Segurança CRV</p>
                        <p>E o ATPV será criado como <b>RENAVE</b></p>"
                    data-bs-html="true">
                  ?
              </span>
            </div>
        </div>
    </div>
    <fieldset class="form-fieldset">
        <h4>Informações do Veículo</h4>
        <div class="row">
            <div class="col-lg-{{$col_length}}">
                <div class="mb-3">
                    <label class="form-label">Placa</label>
                    <input type="text" class="form-control text-uppercase"
                           maxlength="7" name="placa" wire:model.defer="placa">
                </div>
            </div>
            <div class="col-lg-{{$col_length}}">
                <div class="mb-3">
                    <label class="form-label">Renavan</label>
                    <input x-data x-mask:dynamic="alpineMaskNumero11"
                           type="text" class="form-control" name="renavan"
                           wire:model.defer="renavan">
                </div>
            </div>
            <div class="col-lg-{{$col_length}}">
                <div class="mb-3">
                    <label class="form-label">Número CRV</label>
                    <input x-data x-mask:dynamic="alpineMaskNumero12"
                           type="text" class="form-control" name="numeroCrv"
                           wire:model.defer="numeroCrv">
                </div>
            </div>
            @if($isRenave)
                <div class="col-lg-{{$col_length}}">
                <div class="mb-3">
                    <label class="form-label">Código Segurança CRV</label>
                    <input x-data x-mask:dynamic="alpineMaskNumero12"
                           type="text" class="form-control" name="codigoCrv"
                           wire:model.defer="codigoCrv">
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Hodômetro</label>
                    <div class="input-icon">
                        <input x-data x-mask:dynamic="alpineMaskNumero"
                               type="text" class="form-control" name="hodometro"
                               wire:model.defer="hodometro">
                        <span class="input-icon-addon fw-bold">
                            KM
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Data Hora Medição</label>
                    <input type="datetime-local" class="form-control" name="dataHodometro"
                           wire:model.defer="horaHodometro">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Valor de Venda</label>
                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>
                        <input x-data x-mask:dynamic="$money($input, '.','')"
                               type="text" class="form-control"
                               name="precoVenda" wire:model.defer="precoVenda">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label">Veículo</label>
                    <input type="text" class="form-control" name="veiculo"
                           wire:model.defer="veiculo">
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="form-fieldset">
        <h4>Informações do Vendedor</h4>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control" name="vendedorEmail"
                           wire:model.defer="vendedorEmail">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input
                        type="text" class="form-control imask-telefone" name="vendedorTelefone"
                        wire:model.defer="vendedorTelefone">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">CPF/CNPJ</label>
                    <input type="text" class="form-control imask-cpf-cnpj" name="vendedorCpfCnpj"
                           wire:model.defer="vendedorCpfCnpj">
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="form-fieldset">
        <h4>Informações do Comprador</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="email" class="form-control" name="compradorNome"
                           wire:model.defer="compradorNome">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control" name="compradorEmail"
                           wire:model.defer="compradorEmail">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input
                        type="text" class="form-control imask-telefone" name="compradorTelefone"
                        wire:model.defer="compradorTelefone">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">CPF/CNPJ</label>
                    <input type="text" class="form-control imask-cpf-cnpj" name="compradorCpfCnpj"
                           wire:model.defer="compradorCpfCnpj">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="mb-3">
                    <label class="form-label">CEP</label>
                    <input x-data x-mask:dynamic="alpineMaskCep"
                           id="cep" type="text" class="form-control" name="cep"
                           wire:model.defer="cep">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="mb-3">
                    <label class="form-label">Logradouro</label>
                    <input type="text" class="form-control" name="logradouro"
                           wire:model.defer="logradouro">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="form-label">Número</label>
                    <input x-data x-mask:dynamic="alpineMaskNumero"
                           type="text" class="form-control" name="numero"
                           wire:model.defer="numero">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Bairro</label>
                    <input type="text" class="form-control" name="bairro"
                           wire:model.defer="bairro">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="mb-3">
                    <label class="form-label">Município</label>
                    <input type="text" class="form-control" name="municipio"
                           wire:model.defer="municipio">
                </div>
            </div>
            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="form-label">UF</label>
                    <input x-data x-mask:dynamic="alpineMaskUf"
                           id="uf" type="text" class="form-control text-uppercase px-2" name="uf"
                           wire:model.defer="uf">
                </div>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-lg-12">
            <label class="form-label">Observação</label>
            <textarea class="form-control" name="observacao"
                      wire:model.defer="observacao"></textarea>
        </div>
    </div>
</div>
