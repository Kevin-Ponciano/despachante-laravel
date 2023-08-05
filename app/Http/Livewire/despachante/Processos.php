<?php

namespace App\Http\Livewire\despachante;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Processos extends Component
{
    use WithPagination;

    public $search;
    public $paginate = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $iconDirection = 'up';
    public $clientes;
    public $cliente;
    public $status;
    public $tipo;
    public $comprador;
    public $retorno;
    public $queryString = [
        'cliente' =>
            ['except' => ''],
        'paginate' =>
            ['except' => '10'],
        'status' =>
            ['except' => ''],
        'tipo'
        => ['except' => ''],
        'comprador'
        => ['except' => ''],
        'retorno'
        => ['except' => ''],
    ];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        '$refresh',
        'resetSearch'
    ];


    public function mount()
    {
        $this->clientes = Auth::user()->despachante->clientes;
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'cliente',
            'status',
            'tipo',
            'comprador',
            'retorno',
        ]);
    }

    public function render()
    {

        $pedidosQuery = Auth::user()->despachante->pedidosProcessos()->with('processo', 'cliente')
            ->where('pedidos.status', '!=', 'ex')
            ->when($this->cliente, function (Builder $query, $cliente) {
                return $query->where('cliente_id', $cliente);
            })
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
            ->when($this->retorno, function (Builder $query, $retorno) {
                return $query->where('pedidos.retorno_pendencia', $retorno);
            })
            ->when($this->sortField, function (Builder $query, $sortField) {
                return $query->join('processos', 'processos.pedido_id', '=', 'pedidos.id')
                    ->orderBy($sortField, $this->sortDirection);
            });

        $pedidos = $pedidosQuery
            ->where(function (Builder $query) {
                $query->where('comprador_nome', 'like', '%' . $this->search . '%');
                $query->orWhere('pedidos.id', 'like', '%' . $this->search . '%');
                $query->orWhere('clientes.nome', 'like', '%' . $this->search . '%');
                $query->orWhere('pedidos.placa', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->paginate);

        $this->iconDirection = $this->sortDirection === 'asc' ? 'up' : 'down';
        return view('livewire.despachante.processos', [
            'pedidos' => $pedidos
        ])->layout('layouts.despachante');
    }
}
