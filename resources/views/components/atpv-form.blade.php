<div>
    <fieldset class="form-fieldset">
        <h4>Informações do Veículo
            @if($atpvShow?? false)
                <span x-show="checkPendencia" class="ms-1 badge-blink text-warning">Marque os campos que estiverem incorretos</span>
            @endif
        </h4>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Placa
                            <span x-show="isPendingInput.placa" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" wire:model="inputPendencias.placa" type="checkbox"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input type="text"
                           class="form-control @error('veiculo.placa') is-invalid @enderror text-uppercase"
                           maxlength="7" wire:model.defer="veiculo.placa"
                           x-ref="inputRef" x-init="$refs.inputRef = $el"
                           :readonly="isEditing ? false : !isPendingInput.placa">
                    @error('veiculo.placa')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Renavam
                            <span x-show="isPendingInput.renavam" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" wire:model="inputPendencias.renavam" type="checkbox"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input x-mask:dynamic="alpineMaskNumero11" :readonly="isEditing ? false : !isPendingInput.renavam"
                           type="text" class="form-control @error('veiculo.renavam') is-invalid @enderror"
                           wire:model.defer="veiculo.renavam">
                    @error('veiculo.renavam')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Número CRV
                            <span x-show="isPendingInput.numero_crv" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.numero_crv"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input x-mask:dynamic="alpineMaskNumero12"
                           :readonly="isEditing ? false : !isPendingInput.numero_crv"
                           type="text" class="form-control @error('veiculo.numeroCrv') is-invalid @enderror"
                           wire:model.defer="veiculo.numeroCrv">
                    @error('veiculo.numeroCrv')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            @if($isRenave)
                <div class="col">
                    <div class="mb-3">
                        <div class="row">
                            <label class="form-label col-auto text-nowrap">Código Segurança CRV
                                <span x-show="isPendingInput.codigo_seguranca_crv"
                                      class="text-warning ms-1">Incorreto</span>
                            </label>
                            @if($atpvShow?? false)
                                <input x-show="checkPendencia" type="checkbox"
                                       wire:model="inputPendencias.codigo_seguranca_crv"
                                       class="form-check-input-warning mt-1"/>
                            @endif
                        </div>
                        <input x-mask:dynamic="alpineMaskNumero12"
                               :readonly="isEditing ? false : !isPendingInput.codigo_seguranca_crv"
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
                    <div class="row">
                        <label class="form-label col-auto">Hodômetro @if(!$isRenave)
                                <span class="text-muted">opcional</span>
                            @endif
                            <span x-show="isPendingInput.hodometro" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.hodometro"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <div class="input-icon">
                        <input x-mask:dynamic="alpineMaskNumero"
                               :readonly="isEditing ? false : !isPendingInput.hodometro"
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
                    <div class="row">
                        <label class="form-label col-auto">Data Hora Medição @if(!$isRenave)
                                <span class="text-muted">opcional</span>
                            @endif
                            <span x-show="isPendingInput.data_hora_medicao" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.data_hora_medicao"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i class="ti ti-calendar"></i>
                        </span>
                        <input type="datetime-local" :readonly="isEditing ? false : !isPendingInput.data_hora_medicao"
                               class="form-control @error('veiculo.dataHodometro') is-invalid @enderror"
                               wire:model.defer="veiculo.dataHodometro">
                        @error('veiculo.dataHodometro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Valor de Venda
                            <span x-show="isPendingInput.preco_venda" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.preco_venda"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>
                        <input x-mask:dynamic="$money($input, ',','.')"
                               :readonly="isEditing ? false : !isPendingInput.preco_venda"
                               type="text"
                               class="form-control @error('veiculo.precoVenda') is-invalid @enderror @error('veiculo.precoVenda') is-invalid @enderror"
                               wire:model.defer="veiculo.precoVenda">
                        @error('veiculo.precoVenda') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Veículo
                            <span x-show="isPendingInput.veiculo" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.veiculo"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.veiculo"
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
                    <div class="row">
                        <label class="form-label col-auto">E-mail
                            <span x-show="isPendingInput.email_do_vendedor" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.email_do_vendedor"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.email_do_vendedor"
                           class="form-control @error('vendedor.email') is-invalid @enderror"
                           wire:model.defer="vendedor.email">
                    @error('vendedor.email')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Telefone
                            <span x-show="isPendingInput.telefone_do_vendedor"
                                  class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.telefone_do_vendedor"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.telefone_do_vendedor"
                           type="text"
                           class="form-control @error('vendedor.telefone') is-invalid @enderror imask-telefone"
                           wire:model.defer="vendedor.telefone">
                    @error('vendedor.telefone')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">CPF/CNPJ
                            <span x-show="isPendingInput.cpf_cnpj_do_vendedor"
                                  class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.cpf_cnpj_do_vendedor"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.cpf_cnpj_do_vendedor"
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
                    <div class="row">
                        <label class="form-label col-auto">Nome
                            <span x-show="isPendingInput.nome_do_comprador" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.nome_do_comprador"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.nome_do_comprador"
                           type="text" class="form-control @error('comprador.nome') is-invalid @enderror"
                           wire:model.defer="comprador.nome">
                    @error('comprador.nome')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">E-mail
                            <span x-show="isPendingInput.email_do_comprador" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.email_do_comprador"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.email_do_comprador"
                           class="form-control @error('comprador.email') is-invalid @enderror"
                           wire:model.defer="comprador.email">
                    @error('comprador.email')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Telefone
                            <span x-show="isPendingInput.telefone_do_comprador"
                                  class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.telefone_do_comprador"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.telefone_do_comprador"
                           type="text"
                           class="form-control @error('comprador.telefone') is-invalid @enderror imask-telefone"
                           wire:model.defer="comprador.telefone">
                    @error('comprador.telefone')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">CPF/CNPJ
                            <span x-show="isPendingInput.cpf_cnpj_do_comprador"
                                  class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox"
                                   wire:model="inputPendencias.cpf_cnpj_do_comprador"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.cpf_cnpj_do_comprador"
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
                    <div class="row">
                        <label class="form-label col-auto">CEP
                            <span x-show="isPendingInput.cep" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.cep"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input x-mask:dynamic="alpineMaskCep" :readonly="isEditing ? false : !isPendingInput.cep"
                           type="text" class="form-control @error('endereco.cep') is-invalid @enderror"
                           wire:model.defer="endereco.cep" wire:change="setEndereco">
                    @error('endereco.cep')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-7">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Logradouro
                            <span x-show="isPendingInput.logradouro" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.logradouro"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.logradouro"
                           type="text" class="form-control @error('endereco.logradouro') is-invalid @enderror"
                           wire:model.defer="endereco.logradouro">
                    @error('endereco.logradouro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-2">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Número
                            <span x-show="isPendingInput.numero" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.numero"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.numero"
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
                    <div class="row">
                        <label class="form-label col-auto">Bairro
                            <span x-show="isPendingInput.bairro" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.bairro"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.bairro"
                           type="text" class="form-control @error('endereco.bairro') is-invalid @enderror"
                           wire:model.defer="endereco.bairro">
                    @error('endereco.bairro')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">Cidade
                            <span x-show="isPendingInput.cidade" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.cidade"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input :readonly="isEditing ? false : !isPendingInput.cidade"
                           type="text" class="form-control @error('endereco.cidade') is-invalid @enderror"
                           wire:model.defer="endereco.cidade">
                    @error('endereco.cidade')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-2">
                <div class="mb-3">
                    <div class="row">
                        <label class="form-label col-auto">UF
                            <span x-show="isPendingInput.uf" class="text-warning ms-1">Incorreto</span>
                        </label>
                        @if($atpvShow?? false)
                            <input x-show="checkPendencia" type="checkbox" wire:model="inputPendencias.uf"
                                   class="form-check-input-warning mt-1"/>
                        @endif
                    </div>
                    <input x-mask:dynamic="alpineMaskUf" :readonly="isEditing ? false : !isPendingInput.uf"
                           type="text"
                           class="form-control @error('endereco.uf') is-invalid @enderror text-uppercase px-2"
                           wire:model.defer="endereco.uf">
                    @error('endereco.uf')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-12">
            <label class="form-label col-auto">Observação @if($obs?? false)
                @else
                    <span class="text-muted">opcional</span>
                @endif</label>
            <textarea class="form-control @error('observacoes') is-invalid @enderror" :disabled="{{$obs?? 'false'}}"
                      wire:model.defer="observacoes"></textarea>
            @error('observacoes')<span class="invalid-feedback"> {{ $message }}</span> @enderror
        </div>
    </div>
</div>
