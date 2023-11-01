<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Configurações e Dados da Empresa
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader mb-1">Configurações Gerais</h4>
                            <div class="list-group list-group-transparent">
                                <a href="#dados" data-bs-toggle="tab" aria-selected="true" role="tab"
                                   class="list-group-item list-group-item-action d-flex align-items-center active">
                                    Dados
                                </a>
                                <a href="#notificacoes" data-bs-toggle="tab" aria-selected="true" role="tab"
                                   class="list-group-item list-group-item-action d-flex align-items-center">
                                    Notificações
                                </a>
                                <a href="#configuracoes" data-bs-toggle="tab" aria-selected="true" role="tab"
                                   class="list-group-item list-group-item-action d-flex align-items-center">
                                    Configurações
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content card-body col-12 col-md-9 d-flex flex-column">
                        <div class="tab-pane active show" id="dados" role="tabpanel">
                            <fieldset class="form-fieldset">
                                <div class="d-flex">
                                    <h3 class="subheader mb-1">Dados da Empresa</h3>
                                    <x-helper>
                                        Para Alterar estes Dados entre em contato com o Suporte<br>
                                    </x-helper>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md">
                                        <div class="form-label">Razão Social</div>
                                        <input type="text" class="form-control"
                                               wire:model.defer="despachante.razao_social"
                                               disabled>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Nome Fantasia</div>
                                        <input type="text" class="form-control"
                                               wire:model.defer="despachante.nome_fantasia"
                                               disabled>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label imask-cpf-cnpj">CNPJ</div>
                                        <input type="text" class="form-control" wire:model.defer="despachante.cnpj"
                                               disabled>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-fieldset">
                                 <div class="d-flex">
                                    <h3 class="subheader mb-1">Endereço</h3>
                                    <x-helper>
                                        Para Alterar estes Dados entre em contato com o Suporte<br>
                                    </x-helper>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <div class="form-label">Rua</div>
                                        <input type="text" class="form-control"
                                               wire:model="despachante.endereco.logradouro"
                                               disabled>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-label ">Complemento</div>
                                        <input type="text" class="form-control"
                                               wire:model="despachante.endereco.complemento" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-label">Número</div>
                                        <input type="text" class="form-control" wire:model="despachante.endereco.numero"
                                               disabled>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-label ">Bairro</div>
                                        <input type="text" class="form-control" wire:model="despachante.endereco.bairro"
                                               disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-label ">Cidade</div>
                                        <input type="text" class="form-control" wire:model="despachante.endereco.cidade"
                                               disabled>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-label ">UF</div>
                                        <input type="text" class="form-control" wire:model="despachante.endereco.estado"
                                               disabled>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label ">CEP</div>
                                        <input type="text" class="form-control" wire:model="despachante.endereco.cep"
                                               disabled>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-fieldset">
                                <h3 class="subheader mb-1">Contato</h3>
                                <div class="row g-3">
                                    <div class="col-md">
                                        <div class="form-label">E-mail</div>
                                        <input type="email"
                                               class="form-control @error('despachante.email') is-invalid @enderror"
                                               wire:model.defer="despachante.email">
                                        @error('despachante.email')<span
                                            class="invalid-feedback"> {{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Celular</div>
                                        <input type="text"
                                               class="form-control imask-telefone @error('despachante.celular') is-invalid @enderror"
                                               wire:model.defer="despachante.celular">
                                        @error('despachante.celular')<span
                                            class="invalid-feedback"> {{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Celular Secundário</div>
                                        <input type="text"
                                               class="form-control imask-telefone @error('despachante.celular_secundario') is-invalid @enderror"
                                               wire:model.defer="despachante.celular_secundario">
                                        @error('despachante.celular_secundario')<span
                                            class="invalid-feedback"> {{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-fieldset">
                                <h3 class="subheader mb-1">Outros</h3>
                                <div class="row g-3">
                                    <div class="col-md">
                                        <div class="form-label">Site</div>
                                        <input type="text" class="form-control"
                                               wire:model.defer="despachante.site"
                                               placeholder="https://www.site.com.br">
                                    </div>
                                </div>
                            </fieldset>

                            <div class="btn-list">
                                <button type="button" class="btn btn-primary" wire:click="update">Salvar</button>
                            </div>

                        </div>
                        <div id="noticacoes" class="tab-pane" role="tabpanel"></div>
                        <div id="configuracoes" class="tab-pane" role="tabpanel"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
