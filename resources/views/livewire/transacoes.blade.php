<div class="mt-6">
    <div class="page-header m-0 d-print-none z-2">
        <div class="mx-8">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="d-flex gap-2">
                        <div class="btn-list">
                            @if($tipo === 'in')
                                <x-transacoes.btn-dropdown label="Receitas" color="green"/>
                            @elseif($tipo === 'out')
                                <x-transacoes.btn-dropdown label="Despesas" color="red"/>
                            @else
                                <x-transacoes.btn-dropdown label="Transações" color="primary"/>
                            @endif
                            <div class="dropdown-menu fade mt-2">
                                <button wire:click="setTipo(null)" class="dropdown-item change-url"
                                        data-url="transacoes">
                                    <span class="badge bg-primary me-2"></span>
                                    Transações
                                </button>
                                <button wire:click="setTipo('in')" class="dropdown-item change-url"
                                        data-url="receitas">
                                    <span class="badge bg-green me-2"></span>
                                    Receitas
                                </button>
                                <button wire:click="setTipo('out')" class="dropdown-item change-url"
                                        data-url="despesas">
                                    <span class="badge bg-red me-2"></span>
                                    Despesas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-list">
                    @if($tipo === 'in')
                        <x-transacoes.btn-novo label="NOVA RECEITA" color="green"/>
                    @elseif($tipo === 'out')
                        <x-transacoes.btn-novo label="NOVA DESPESA" color="red"/>
                    @endif
                    <button class="btn rounded-5">
                        <i class="ti ti-search"></i>
                    </button>
                    <button class="btn rounded-5">
                        <i class="ti ti-filter"></i>
                    </button>
                    <button class="btn rounded-5">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="mx-8">
            <div class="d-flex justify-content-between">
                <div class="card w-75 h-100">
                    <x-transacoes.meses :tipo="$tipo" :mes="$mes" :ano="$ano" :show-month="$showMonth"/>
                    <x-transacoes.table :transacoes="$transacoes"/>
                </div>
                <div>
                    @if($tipo === 'in')
                        <x-transacoes.card label="Receitas Pendentes" icon="ti ti-arrow-up"
                                           bg="bg-green" :valor="$saldoPe"/>
                        <x-transacoes.card label="Receitas Recebidas" icon="ti ti-arrow-down"
                                           bg="bg-green" :valor="$saldoPg"/>
                        <x-transacoes.card label="Total" icon="ti ti-scale" bg="bg-green" :valor="$total"/>
                    @elseif($tipo === 'out')
                        <x-transacoes.card label="Despesas Pendentes" icon="ti ti-arrow-up"
                                           bg="bg-red" :valor="$saldoPe"/>
                        <x-transacoes.card label="Despesas Pagas" icon="ti ti-arrow-down"
                                           bg="bg-red" :valor="$saldoPg"/>
                        <x-transacoes.card label="Total" icon="ti ti-scale" bg="bg-red" :valor="$total"/>
                    @else
                        <x-transacoes.card functions="wire:click=setTipo('in')" label="Receitas" icon="ti ti-arrow-up"
                                           bg="bg-green" :valor="$saldoReceitas"/>
                        <x-transacoes.card functions="wire:click=setTipo('out')" label="Despesas"
                                           icon="ti ti-arrow-down"
                                           bg="bg-red" :valor="$saldoDespesas"/>
                        <x-transacoes.card label="Balanço mensal" icon="ti ti-scale" bg="bg-blue" :valor="$balanco"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.toggle-months').click(function () {
                $('#months-menu').slideToggle();
            });

            $('.change-url').on('click', function () {
                const tipo = $(this).data('url').toLowerCase()
                if (tipo !== 'receitas' && tipo !== 'despesas' && tipo !== 'transacoes') return
                if (tipo === 'transacoes')
                    history.pushState(null, null, '/despachante/transacoes');
                else
                    history.pushState(null, null, '/despachante/transacoes/' + tipo);
            })
        });
    </script>
</div>
