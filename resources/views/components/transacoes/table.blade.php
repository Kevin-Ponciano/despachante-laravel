<div class="px-0 py-2">
    <table id="transacoes-table" class="bg-body-tertiary table table-mobile-xl card-table">
        <thead>
        <tr>
            <th class="fw-bolder cursor-pointer" wire:click="sortBy('status')">Situação
                <i class="ti ti-arrow-big-{{$sortField === 'status' ? $iconDirection : null}}-filled"></i>
            </th>
            <th class="fw-bolder cursor-pointer" wire:click="sortBy('data_vencimento')">Data
                <i class="ti ti-arrow-big-{{$sortField === 'data_vencimento' ? $iconDirection : null}}-filled"></i>
            </th>
            <th class="fw-bolder cursor-pointer" wire:click="sortBy('descricao')">Descrição
                <i class="ti ti-arrow-big-{{$sortField === 'descricao' ? $iconDirection : null}}-filled"></i>
            </th>
            <th class="fw-bolder cursor-pointer" wire:click="sortBy('categoria_id')">Categoria
                <i class="ti ti-arrow-big-{{$sortField === 'categoria_id' ? $iconDirection : null}}-filled"></i>
            </th>
            <th class="fw-bolder cursor-pointer" wire:click="sortBy('valor')">Valor
                <i class="ti ti-arrow-big-{{$sortField === 'valor' ? $iconDirection : null}}-filled"></i>
            </th>
            <th class="fw-bolder">Ações</th>
        </tr>
        </thead>
        <tbody class="table-tbody">
        @forelse($transacoes as $transacao)
            <tr>
                <td>
                    <div class="badge bg-{{$transacao->getStatus()['color']}} badge-pill"
                         data-bs-toggle="tooltip" data-bs-placement="bottom"
                         aria-label="{{$transacao->getStatus()['text']}}"
                         data-bs-original-title="{{$transacao->getStatus()['text']}}">
                        <i class="{{ $transacao->getStatus()['icon'] }}"></i>
                    </div>
                </td>
                <td>{{ $transacao->getDataVencimento() }}</td>
                <td>{{ $transacao->getDescricao() }}</td>
                <td>
                    <div class="badge bg-{{$transacao->categoria->cor}} badge-pill me-2">
                        <i class="{{ $transacao->categoria->icone }}"></i>
                    </div>
                    {{ $transacao->categoria->nome }}
                </td>
                <td class="@if($transacao->tipo === 'in') text-green @else text-red @endif">
                    R$ {{ $transacao->getValor() }}</td>
                <td>
                    <div class="btn-list flex-nowrap">
                        <button class="btn btn-sm btn-icon btn-ghost-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#nova-transacao-modal"
                                wire:click="edit({{$transacao->id}})">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-ghost-danger"
                                wire:click="delete({{$transacao->id}})">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
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
