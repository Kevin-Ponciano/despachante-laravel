<?php

namespace App\Http\Livewire;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Processos extends Component
{
    use WithPagination;

    public $search;
    public $paginate = 10;
    public $sortField = 'numero_pedido';
    public $sortDirection = 'desc';
    public $iconDirection = 'up';
    public $clientes;
    public $cliente;
    public $status;
    public $tipo;
    public $downloadDisponivel;
    public $comprador;
    public $queryString = [
        'cliente' => ['except' => ''],
        'paginate' => ['except' => '10'],
        'status' => ['except' => ''],
        'tipo' => ['except' => ''],
        'comprador' => ['except' => ''],
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

    public function show($id)
    {
        if (Auth::user()->isDespachante())
            return redirect()->route('despachante.processos.show', $id);
        elseif (Auth::user()->isCliente())
            return redirect()->route('cliente.processos.show', $id);
        else
            return null;
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'cliente',
            'status',
            'tipo',
            'comprador',
            'downloadDisponivel',
            'paginators'
        ]);
    }

    public function render()
    {
        $pedidosQuery = Auth::user()->empresa()->pedidosProcessos()->with('processo', 'cliente')
            ->when($this->status, function (Builder $query, $status) {
                return $query->where('pedidos.status', $status);
            })
            ->when($this->tipo, function (Builder $query, $tipo) {
                return $query->whereHas('processo', function (Builder $query) use ($tipo) {
                    $query->where('tipo', $tipo);
                });
            })
            ->when($this->comprador, function (Builder $query, $comprador) {
                return $query->whereHas('processo', function (Builder $query) use ($comprador) {
                    $query->where('comprador_tipo', $comprador);
                });
            })
            ->when($this->downloadDisponivel, function (Builder $query, $downloadDisponivel) {
                return $query->whereHas('arquivos', function (Builder $query) use ($downloadDisponivel) {
                    $query->where('folder', 'cod_crlv');
                });
            });

        if (Auth::user()->isCliente()) {
            $pedidosQuery = $pedidosQuery->orderBy($this->sortField, $this->sortDirection);
        } else {
            $pedidosQuery = $pedidosQuery
                ->when($this->cliente, function (Builder $query, $cliente) {
                    return $query->where('cliente_id', $cliente);
                })
                ->when($this->sortField, function (Builder $query, $sortField) {
                    return $query->join('processos', 'processos.pedido_id', '=', 'pedidos.id')
                        ->orderBy($sortField, $this->sortDirection);
                });
        }

        $pedidos = $pedidosQuery
            ->where(function (Builder $query) {
                $query->where('comprador_nome', 'like', $this->search . '%');
                $query->orWhere('pedidos.numero_pedido', 'like', $this->search . '%');
                if (Auth::user()->isDespachante())
                    $query->orWhere('clientes.nome', 'like', $this->search . '%');
                $query->orWhere('pedidos.placa', 'like', $this->search . '%');
            })
            ->paginate($this->paginate);
        $this->iconDirection = $this->sortDirection === 'asc' ? 'up' : 'down';

        return view('livewire.processos', [
            'pedidos' => $pedidos
        ]);
    }
}
