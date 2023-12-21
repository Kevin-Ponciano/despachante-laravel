@php
    if(!$color)
        $color = $tipo === 'in' ? 'success' : 'danger';
    $transacaoTipo = $color === 'success' ? 'receita' : 'despesa';

@endphp
<div wire:ignore.self class="modal modal-blur fade" id="deletar-transacao-modal" tabindex="-1" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-5">
            <div class="modal-header border-0">
                <h2 class="text-{{$color}} text-capitalize fw-bolder">Deletar {{$transacaoTipo}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0 row">
                <div class="col-6 text-muted">
                    <label>Descrição</label>
                    <div>{{$transacao['descricao']}}</div>
                </div>
                <div class="col-6 text-muted">
                    <label>Valor</label>
                    <div>R$ {{$transacao['valor']}}</div>
                </div>
                <div class="col-12 mt-4">
                    <h3>Atenção! Está é uma {{$transacaoTipo}} recorrente.<br>Você deseja deletar:</h3>
                    <div>
                        <label class="form-check">
                            <input class="form-check-input-{{$color}}" type="radio" value="this"
                                   name="deletar_opcao"
                                   style="float: left;margin-left: -1.5rem;" wire:model="recorrenteOpcao">
                            <span class="form-check-label">Somente esta</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input-{{$color}}" type="radio" value="pendentes"
                                   name="deletar_opcao"
                                   style="float: left;margin-left: -1.5rem;" wire:model="recorrenteOpcao">
                            <span class="form-check-label">Esta, e as futuras</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input-{{$color}}" type="radio" value="all"
                                   name="deletar_opcao"
                                   style="float: left;margin-left: -1.5rem;" wire:model="recorrenteOpcao">
                            <span class="form-check-label">Todas as receitas, incluindo as passadas</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="btn-list mx-5 my-3">
                <button type="button" class="btn btn-outline-{{$color}} me-auto rounded-5" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-{{$color}} ms-auto rounded-5" wire:click="destroy">Deletar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#deletar-transacao-modal').modal({
            backdrop: 'static',
        })
    })
</script>
