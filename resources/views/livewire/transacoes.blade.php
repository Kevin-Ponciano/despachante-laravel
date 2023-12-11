<div class="mt-6">
    <div class="page-header m-0 d-print-none z-2">
        <div class="mx-8">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="d-flex gap-2">
                        <div>
                            <div class="page-title">
                                <button class="btn btn-primary rounded-5 dropdown-toggle">
                                    Transações
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="btn-list">
                        <button class="btn btn-primary">
                            Pesquisar
                        </button>
                        <button class="btn btn-ghost-success">
                            Filtro
                        </button>
                        <button class="btn btn-danger">
                            Dots
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="mx-8">
            <div class="d-flex justify-content-between">
                <div class="card w-75">
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <div>
                            <button class="btn btn-ghost-primary rounded-5 mx-1"
                                    wire:click="previous"> &lt;
                            </button>
                            <button class="toggle-months text-capitalize btn btn-outline-primary rounded-5 mx-1"
                                    wire:click="toggleShowMonth">
                                @if($showMonth)
                                    {{ $mes }}
                                @endif
                                {{$ano}}
                            </button>
                            <button class="btn btn-ghost-primary rounded-5 mx-1"
                                    wire:click="next"> &gt;
                            </button>
                        </div>
                    </div>
                    <div wire:ignore id="months-menu" style="display: none;">
                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <button wire:click="setMonth(1)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Jan
                            </button>
                            <button wire:click="setMonth(2)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Fev
                            </button>
                            <button wire:click="setMonth(3)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Mar
                            </button>
                            <button wire:click="setMonth(4)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Abr
                            </button>
                            <button wire:click="setMonth(5)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Mai
                            </button>
                            <button wire:click="setMonth(6)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Jun
                            </button>
                            <button wire:click="setMonth(7)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Jul
                            </button>
                            <button wire:click="setMonth(8)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Ago
                            </button>
                            <button wire:click="setMonth(9)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Set
                            </button>
                            <button wire:click="setMonth(10)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Out
                            </button>
                            <button wire:click="setMonth(11)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Nov
                            </button>
                            <button wire:click="setMonth(12)"
                                    class="toggle-months btn btn-outline-primary rounded-5 mx-1">
                                Dez
                            </button>
                        </div>
                    </div>

                    <div class="px-0 py-2">
                        <div>
                            <table id="transacoes-table" class="bg-body-tertiary table table-mobile-xl card-table">
                                <thead>
                                <tr>
                                    <th class="fw-bolder text-white">Situação</th>
                                    <th class="fw-bolder text-white">Data</th>
                                    <th class="fw-bolder text-white">Descrição</th>
                                    <th class="fw-bolder text-white">Categoria</th>
                                    <th class="fw-bolder text-white">Valor</th>
                                    <th class="fw-bolder text-white">Ações</th>
                                </tr>
                                </thead>
                                <tbody class="table-tbody">
                                @forelse($transacoes as $transacao)
                                    <tr>
                                        <td>{{ $transacao->status }}</td>
                                        <td>{{ $transacao->getDataVencimento() }}</td>
                                        <td>{{ $transacao->descricao }}</td>
                                        <td>{{ $transacao->categoria->nome }}</td>
                                        <td>{{ $transacao->valor }}</td>
                                        <td>
                                            <!-- Add actions here -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No transactions found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-2">
                            {{$transacoes->links()}}
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card card-sm" style="width: 20rem">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                        <span class="bg-green-lt avatar"><!-- Download SVG icon from http://tabler-icons.io/i/arrow-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                               viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                               stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none"></path><path
                                  d="M12 5l0 14"></path><path d="M18 11l-6 -6"></path><path d="M6 11l6 -6"></path></svg>
                        </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        $5,256.99
                                        <span class="float-right font-weight-medium text-green">+4%</span>
                                    </div>
                                    <div class="text-secondary">
                                        Revenue last 30 days
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                        <span class="bg-green-lt avatar"><!-- Download SVG icon from http://tabler-icons.io/i/arrow-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                               viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                               stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none"></path><path
                                  d="M12 5l0 14"></path><path d="M18 11l-6 -6"></path><path d="M6 11l6 -6"></path></svg>
                        </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        $5,256.99
                                        <span class="float-right font-weight-medium text-green">+4%</span>
                                    </div>
                                    <div class="text-secondary">
                                        Revenue last 30 days
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                        <span class="bg-green-lt avatar"><!-- Download SVG icon from http://tabler-icons.io/i/arrow-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                               viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                               stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none"></path><path
                                  d="M12 5l0 14"></path><path d="M18 11l-6 -6"></path><path d="M6 11l6 -6"></path></svg>
                        </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        $5,256.99
                                        <span class="float-right font-weight-medium text-green">+4%</span>
                                    </div>
                                    <div class="text-secondary">
                                        Revenue last 30 days
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.toggle-months').click(function () {
                $('#months-menu').slideToggle();
            });
        });
    </script>
</div>
