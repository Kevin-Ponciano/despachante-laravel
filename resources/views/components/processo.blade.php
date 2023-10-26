<div class="row">
    <div class="col-auto">
        <div class="mb-3">
            <div>
                {{$cliente}}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-5">
        <div class="mb-3">
            {{$nomeComprador}}
        </div>
    </div>
    <div class="col-2">
        <div class="mb-3">
            {{$telefone}}
        </div>
    </div>
    <div class="col-5">
        <div class="mb-3">
            {{$responsavel}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="mb-3">
            {{$placa}}
        </div>
    </div>
    <div class="col-8">
        <div class="mb-3">
            {{$veiculo}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="mb-3">
            {{$qtd_placa}}
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3">
            {{$comprador_tipo}}
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3">
            {{$processo_tipo}}
        </div>
    </div>
    @if(Auth::user()->isCliente())
        @if($tipoProcesso === "ss")
            <div class="col-12">
                <fieldset class="form-fieldset mb-3">
                    <div class="is-invalid"></div>
                    @error('servicos')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                    <h4>Serviços</h4>
                    {{$select_servico??''}}
                    <div class="row gap-3">
                        @foreach($servicos as $servico)
                            <div class="col-auto position-relative">
                                <li class="mb-1 me-2 fw-semibold" title="{{$servico['descricao']}}">
                                    {{$servico['nome']}}
                                </li>
                                @if($novoProcesso??false)
                                    <span title="Remover Serviço"
                                          class="cursor-pointer badge bg-red text-red-fg badge-notification badge-pill"
                                          wire:click="removeServico({{$servico['id']}})">
                                <i class="ti ti-x"></i>
                            </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
        @endif
    @endif
    <div class="col-12">
        <div class="mb-3">
            {{$observacao}}
        </div>
    </div>
</div>

