<div>
    <div class="page-header d-print-none">
        <div class="container-narrow">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Serviços
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-narrow">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h5 class="col page-title">
                            Selecione o serviço
                        </h5>
                        <div class="col-4">
                            <select class="form-select" wire:model="servicoIndexSelected">
                                <option value="" selected>Selecione</option>
                                @foreach($servicos as $index => $servico)
                                    <option value="{{$index}}">{{$servico['nome']}}</option>
                                @endforeach
                                <option value="novo">Novo Serviço</option>
                            </select>
                        </div>
                    </div>
                    {{--                    @if($servicoIndexSelected != 'novo' && $servicoIndexSelected != null)--}}
                    <fieldset class="form-fieldset">
                        @if($servicoIndexSelected == 'novo')
                            <h4>Cadastrar Novo Serviço</h4>
                        @else
                            <h4>Editar Serviço</h4>
                        @endif
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="servicos.{{$servicoIndexSelected}}.nome">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Valor</label>
                                    <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-currency-real"></i>
                                    </span>
                                        <input x-data x-mask:dynamic="$money($input, '.','')"
                                               type="text" class="form-control px-5 w-50"
                                               wire:model.defer="servicos.{{$servicoIndexSelected}}.preco">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <textarea rows="5" type="text" class="form-control"
                                              wire:model.defer=
                                                  @if($servicoIndexSelected == 'novo')
                                                      "descricaoNovo"
                                    @else
                                        "servicos.{{$servicoIndexSelected}}.descricao"
                                    @endif
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <button class="btn btn-primary">Salvar</button>
                                <button class="btn btn-ghost-danger">Excluir</button>
                            </div>
                        </div>
                    </fieldset>
                    {{--                    @endif--}}
                </div>
            </div>
        </div>
    </div>
</div>
