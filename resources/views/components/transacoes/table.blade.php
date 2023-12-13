<div class="px-0 py-2">
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
                <td>
                    <div class="badge bg-{{$transacao->getStatus()['color']}} badge-pill">
                        <i class="{{ $transacao->getStatus()['icon'] }}"></i>
                    </div>
                </td>
                <td>{{ $transacao->getDataVencimento() }}</td>
                <td>{{ $transacao->descricao }}</td>
                <td>
                    <div class="badge bg-{{$transacao->categoria->cor}} badge-pill me-2">
                        <i class="{{ $transacao->categoria->icone }}"></i>
                    </div>
                    {{ $transacao->categoria->nome }}
                </td>
                <td class="@if($transacao->tipo === 'in') text-green @else text-red @endif">
                    R$ {{ $transacao->getValor() }}</td>
                <td>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center"> Nenhuma transação encontrada.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="p-2">
    {{$transacoes->links()}}
</div>
