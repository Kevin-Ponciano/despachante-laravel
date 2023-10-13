<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Atpvs extends Component
{
    use WithPagination;

    public $search;
    public $paginate = 10;
    public $sortField = 'pedidos.numero_pedido';
    public $sortDirection = 'desc';
    public $iconDirection = 'up';
    public $clientes;
    public $cliente;
    public $status;
    public $tipo;
    public $downloadDisponivel;
    public $movimentacao;
    public $queryString = [
        'cliente' => ['except' => ''],
        'paginate' => ['except' => '10'],
        'status' => ['except' => ''],
        'tipo' => ['except' => ''],
        'movimentacao' => ['except' => ''],
        'downloadDisponivel' => ['except' => ''],
    ];


    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        '$refresh',
        'resetSearch'
    ];

    public function mount()
    {
        if (Auth::user()->isDespachante())
            $this->clientes = Auth::user()->despachante->clientes;
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function checkTipo()
    {
        if (!$this->tipo == 'rv')
            $this->movimentacao = null;
    }

    public function show($id)
    {
        if (Auth::user()->isDespachante())
            return redirect()->route('despachante.atpvs.show', $id);
        elseif (Auth::user()->isCliente())
            return redirect()->route('cliente.atpvs.show', $id);
        else
            abort(500);
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'cliente',
            'status',
            'tipo',
            'movimentacao',
            'downloadDisponivel',
        ]);
    }

    public function render()
    {
        $pedidosQuery = Auth::user()->empresa()->pedidosAtpvs()->with('atpv', 'cliente')
            ->where('pedidos.status', '!=', 'ex')
            ->when($this->status, function (Builder $query, $status) {
                return $query->where('pedidos.status', $status);
            })
            ->when($this->tipo, function (Builder $query, $tipo) {
                if ($tipo == 'at') {
                    return $query->whereHas('atpv', function (Builder $query) {
                        $query->where('codigo_crv', null);
                    });
                } elseif ($tipo == 'rv') {
                    return $query->whereHas('atpv', function (Builder $query) {
                        $query->where('codigo_crv', '!=', null);
                    });
                }
                return $query;
            })
            ->when($this->movimentacao, function (Builder $query, $movimentacao) {
                return $query->whereHas('atpv', function (Builder $query) use ($movimentacao) {
                    $query->where('movimentacao', $movimentacao);
                });
            })
            ->when($this->downloadDisponivel, function (Builder $query, $downloadDisponivel) {
                return $query->whereHas('arquivos', function (Builder $query) use ($downloadDisponivel) {
                    $query->where('folder', 'atpv');
                    $query->orWhere('folder', 'renave/cliente');
                });
            });

        # TODO: Verificar este problema de ordenação
        if (Auth::user()->isCliente()) {
            $pedidosQuery = $pedidosQuery->orderBy($this->sortField, $this->sortDirection);
        } else {
            $pedidosQuery = $pedidosQuery
                ->when($this->cliente, function (Builder $query, $cliente) {
                    return $query->where('cliente_id', $cliente);
                })
                ->when($this->sortField, function (Builder $query, $sortField) {
                    return $query->join('atpvs', 'atpvs.pedido_id', '=', 'pedidos.id')
                        ->orderBy($sortField, $this->sortDirection);
                });
        }

        $pedidos = $pedidosQuery
            ->where(function (Builder $query) {
                $query->where('comprador_nome', 'like', '%' . $this->search . '%');
                $query->orWhere('pedidos.numero_pedido', 'like', '%' . $this->search . '%');
                if (Auth::user()->isDespachante())
                    $query->orWhere('clientes.nome', 'like', '%' . $this->search . '%');
                $query->orWhere('pedidos.placa', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->paginate);

        $this->iconDirection = $this->sortDirection === 'asc' ? 'up' : 'down';
        return view('livewire.atpvs', [
            'pedidos' => $pedidos
        ]);
    }
}
