<div>
    <fieldset class="form-fieldset">
        <h4>Informações do Veículo</h4>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Placa</label>
                    <input type="text"
                           class="form-control @error('veiculo.placa') is-invalid @enderror text-uppercase"
                           maxlength="7" wire:model.defer="veiculo.placa"
                           x-ref="inputRef" x-init="$refs.inputRef = $el" :readonly="!isEditing">
                    @error('veiculo.placa')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Renavam</label>
                    <input x-mask:dynamic="alpineMaskNumero11" :readonly="!isEditing"
                           type="text" class="form-control @error('veiculo.renavam') is-invalid @enderror"
                           wire:model.defer="veiculo.renavam">
                    @error('veiculo.renavam')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Número CRV</label>
                    <input x-mask:dynamic="alpineMaskNumero12" :readonly="!isEditing"
                           type="text" class="form-control @error('veiculo.numeroCrv') is-invalid @enderror"
                           wire:model.defer="veiculo.numeroCrv">
                    @error('veiculo.numeroCrv')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            @if($isRenave)
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Código Segurança CRV</label>
                        <input x-mask:dynamic="alpineMaskNumero12" :readonly="!isEditing"
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
                    <label class="form-label">Hodômetro @if(!$isRenave)
                            <span class="text-muted">opcional</span>
                        @endif</label>
                    <div class="input-icon">
                        <input x-mask:dynamic="alpineMaskNumero" :readonly="!isEditing"
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
                    <label class="form-label">Data Hora Medição @if(!$isRenave)
                            <span class="text-muted">opcional</span>
                        @endif</label>
                    <input type="datetime-local" :readonly="!isEditing"
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
                        <input x-mask:dynamic="$money($input, ',','.')" :readonly="!isEditing"
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
                    <input :readonly="!isEditing"
                           type="text" class="form-control @error('veiculo.veiculo') is-invalid @enderror"
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
                    <input :readonly="!isEditing"
                           class="form-control @error('vendedor.email') is-invalid @enderror"
                           wire:model.defer="vendedor.email">
                    @error('vendedor.email')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input :readonly="!isEditing"
                           type="text"
                           class="form-control @error('vendedor.telefone') is-invalid @enderror imask-telefone"
                           wire:model.defer="vendedor.telefone">
                    @error('vendedor.telefone')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label class="form-label">CPF/CNPJ</label>
                    <input :readonly="!isEditing"
                           type="text"
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
                    <input :readonly="!isEditing"
                           type="text" class="form-control @error('comprador.nome') is-invalid @enderror"
                           wire:model.defer="comprador.nome">
                    @error('comprador.nome')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input :readonly="!isEditing"
                           class="form-control @error('comprador.email') is-invalid @enderror"
                           wire:model.defer="comprador.email">
                    @error('comprador.email')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input :readonly="!isEditing"
                           type="text"
                           class="form-control @error('comprador.telefone') is-invalid @enderror imask-telefone"
                           wire:model.defer="comprador.telefone">
                    @error('comprador.telefone')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label class="form-label">CPF/CNPJ</label>
                    <input :readonly="!isEditing"
                           type="text"
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
                    <input x-mask:dynamic="alpineMaskCep" :readonly="!isEditing"
                           type="text" class="form-control @error('endereco.cep') is-invalid @enderror"
                           wire:model.defer="endereco.cep" wire:change="setEndereco">
                    @error('endereco.cep')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-7">
                <div class="mb-3">
                    <label class="form-label">Logradouro</label>
                    <input :readonly="!isEditing"
                           type="text" class="form-control @error('endereco.logradouro') is-invalid @enderror"
                           wire:model.defer="endereco.logradouro">
                    @error('endereco.logradouro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-2">
                <div class="mb-3">
                    <label class="form-label">Número</label>
                    <input :readonly="!isEditing"
                           x-mask:dynamic="alpineMaskNumero"
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
                    <input :readonly="!isEditing"
                           type="text" class="form-control @error('endereco.bairro') is-invalid @enderror"
                           wire:model.defer="endereco.bairro">
                    @error('endereco.bairro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label">Cidade</label>
                    <input :readonly="!isEditing"
                           type="text" class="form-control @error('endereco.cidade') is-invalid @enderror"
                           wire:model.defer="endereco.cidade">
                    @error('endereco.cidade')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-2">
                <div class="mb-3">
                    <label class="form-label">UF</label>
                    <input x-mask:dynamic="alpineMaskUf" :readonly="!isEditing"
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
            <label class="form-label">Observação @if($obs?? false)
                @else
                    <span class="text-muted">opcional</span>
                @endif</label>
            <textarea class="form-control @error('observacoes') is-invalid @enderror" :disabled="{{$obs?? 'false'}}"
                      wire:model.defer="observacoes"></textarea>
            @error('observacoes')<span class="invalid-feedback"> {{ $message }}</span> @enderror
        </div>
    </div>
</div>
