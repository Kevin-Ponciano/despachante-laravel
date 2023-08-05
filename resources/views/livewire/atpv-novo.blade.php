<form wire:submit.prevent="store">
    @csrf
    <div x-data class="p-3">
        <div class="d-flex justify-content-between">
            <div class="col-auto">
                <div class="mb-3">
                    <label class="form-label">Cliente Logista</label>
                    <div wire:ignore>
                        <select id="select-cliente-atpv-novo"
                                class="form-control"
                                wire:model.defer="clienteId">
                            @error('clienteId')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                            <option value="-1">Selecione o Cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="is-invalid"></div>
                    @error('clienteId')<span class="invalid-feedback"> {{ $message }}</span> @enderror
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
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Placa</label>
                        <input type="text"
                               class="form-control @error('veiculo.placa') is-invalid @enderror text-uppercase"
                               maxlength="7" wire:model.defer="veiculo.placa">
                        @error('veiculo.placa')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Renavam</label>
                        <input x-mask:dynamic="alpineMaskNumero11"
                               type="text" class="form-control @error('veiculo.renavam') is-invalid @enderror"
                               wire:model.defer="veiculo.renavam">
                        @error('veiculo.renavam')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Número CRV</label>
                        <input x-mask:dynamic="alpineMaskNumero12"
                               type="text" class="form-control @error('veiculo.numeroCrv') is-invalid @enderror"
                               wire:model.defer="veiculo.numeroCrv">
                        @error('veiculo.numeroCrv')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                @if($isRenave)
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Código Segurança CRV</label>
                            <input x-mask:dynamic="alpineMaskNumero12"
                                   type="text" class="form-control @error('veiculo.codigoCrv') is-invalid @enderror"
                                   wire:model.defer="veiculo.codigoCrv">
                            @error('veiculo.codigoCrv')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">Hodômetro <span class="text-muted">opcional</span></label>
                        <div class="input-icon">
                            <input x-mask:dynamic="alpineMaskNumero"
                                   type="text" class="form-control @error('veiculo.hodometro') is-invalid @enderror"
                                   wire:model.defer="veiculo.hodometro">
                            @error('veiculo.hodometro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                            <span class="input-icon-addon fw-bold">
                                KM
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">Data Hora Medição <span class="text-muted">opcional</span></label>
                        <input type="datetime-local"
                               class="form-control @error('veiculo.dataHodometro') is-invalid @enderror"
                               wire:model.defer="veiculo.dataHodometro">
                        @error('veiculo.dataHodometro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
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
                            <input x-mask:dynamic="$money($input, ',','.')"
                                   type="text"
                                   class="form-control @error('veiculo.precoVenda') is-invalid @enderror @error('veiculo.precoVenda') is-invalid @enderror"
                                   wire:model.defer="veiculo.precoVenda">
                            @error('veiculo.precoVenda') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="mb-3">
                        <label class="form-label">Veículo</label>
                        <input type="text" class="form-control @error('veiculo.veiculo') is-invalid @enderror"
                               wire:model.defer="veiculo.veiculo">
                        @error('veiculo.veiculo')<span class="invalid-feedback"> {{ $message }}</span> @enderror
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
                        <input class="form-control @error('vendedor.email') is-invalid @enderror"
                               wire:model.defer="vendedor.email">
                        @error('vendedor.email')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input
                            type="text"
                            class="form-control @error('vendedor.telefone') is-invalid @enderror imask-telefone"
                            wire:model.defer="vendedor.telefone">
                        @error('vendedor.telefone')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">CPF/CNPJ</label>
                        <input type="text"
                               class="form-control @error('vendedor.cpfCnpj') is-invalid @enderror imask-cpf-cnpj"
                               wire:model.defer="vendedor.cpfCnpj">
                        @error('vendedor.cpfCnpj')<span class="invalid-feedback"> {{ $message }}</span> @enderror
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
                        <input type="text" class="form-control @error('comprador.nome') is-invalid @enderror"
                               wire:model.defer="comprador.nome">
                        @error('comprador.nome')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input class="form-control @error('comprador.email') is-invalid @enderror"
                               wire:model.defer="comprador.email">
                        @error('comprador.email')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input
                            type="text"
                            class="form-control @error('comprador.telefone') is-invalid @enderror imask-telefone"
                            wire:model.defer="comprador.telefone">
                        @error('comprador.telefone')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">CPF/CNPJ</label>
                        <input type="text"
                               class="form-control @error('comprador.cpfCnpj') is-invalid @enderror imask-cpf-cnpj"
                               wire:model.defer="comprador.cpfCnpj">
                        @error('comprador.cpfCnpj')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="mb-3">
                        <label class="form-label">CEP</label>
                        <input x-mask:dynamic="alpineMaskCep"
                               type="text" class="form-control @error('endereco.cep') is-invalid @enderror"
                               wire:model.defer="endereco.cep" wire:change="setEndereco">
                        @error('endereco.cep')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-7">
                    <div class="mb-3">
                        <label class="form-label">Logradouro</label>
                        <input type="text" class="form-control @error('endereco.logradouro') is-invalid @enderror"
                               wire:model.defer="endereco.logradouro">
                        @error('endereco.logradouro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-2">
                    <div class="mb-3">
                        <label class="form-label">Número</label>
                        <input x-mask:dynamic="alpineMaskNumero"
                               type="text" class="form-control @error('endereco.numero') is-invalid @enderror"
                               wire:model.defer="endereco.numero">
                        @error('endereco.numero')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" class="form-control @error('endereco.bairro') is-invalid @enderror"
                               wire:model.defer="endereco.bairro">
                        @error('endereco.bairro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" class="form-control @error('endereco.cidade') is-invalid @enderror"
                               wire:model.defer="endereco.cidade">
                        @error('endereco.cidade')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-2">
                    <div class="mb-3">
                        <label class="form-label">UF</label>
                        <input x-mask:dynamic="alpineMaskUf"
                               id="uf" type="text"
                               class="form-control @error('endereco.uf') is-invalid @enderror text-uppercase px-2"
                               wire:model.defer="endereco.uf">
                        @error('endereco.uf')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-12">
                <label class="form-label">Observação <span class="text-muted">opcional</span></label>
                <textarea class="form-control @error('observacoes') is-invalid @enderror" name="observacao"
                          wire:model.defer="observacoes"></textarea>
                @error('observacoes')<span class="invalid-feedback"> {{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer p-3">
        <a href="#" wire:click="clearInputs" class="btn btn-link link-secondary"
           data-bs-dismiss="modal">
            Cancelar
        </a>
        <button type="submit" class="btn btn-primary ms-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Criar novo ATPV
        </button>
    </div>
</form>

