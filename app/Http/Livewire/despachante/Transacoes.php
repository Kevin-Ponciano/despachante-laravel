<?php

namespace App\Http\Livewire\despachante;

use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Transacoes extends Component
{
    use WithPagination;

    public $search;
    public $paginate = 10;
    public $situacao;
    public $data;
    public $descricao;
    public $categoria;
    public $valor;

    public $date;

    public $mes;
    public $ano;

    public $showMonth = true;

    public $sortField = 'data_vencimento';
    public $sortDirection = 'desc';
    public $iconDirection = 'up';

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        '$refresh',
        'resetSearch',
    ];

    public function mount()
    {
        $this->date = Carbon::now();
        $this->mes = $this->date->translatedFormat('F');
        $this->ano = $this->date->year;
    }

    public function previous()
    {
        if ($this->showMonth) {
            $this->previousMonth();
        } else {
            $this->previousYear();
        }
    }

    private function previousMonth()
    {
        $this->date = Carbon::parse($this->date)->subMonth();
        $this->mes = Carbon::parse($this->date)->translatedFormat('F');
        $this->ano = Carbon::parse($this->date)->year;
    }

    private function previousYear()
    {
        $this->date = Carbon::parse($this->date)->subYear();
        $this->ano = Carbon::parse($this->date)->year;
    }

    public function next()
    {
        if ($this->showMonth) {
            $this->nextMonth();
        } else {
            $this->nextYear();
        }

    }

    public function setMonth($month)
    {
        $this->date = Carbon::parse($this->date)->month($month);
        $this->mes = Carbon::parse($this->date)->translatedFormat('F');
        $this->ano = Carbon::parse($this->date)->year;
        $this->showMonth = true;
    }

    private function nextMonth()
    {
        $this->date = Carbon::parse($this->date)->addMonth();
        $this->mes = Carbon::parse($this->date)->translatedFormat('F');
        $this->ano = Carbon::parse($this->date)->year;
    }

    private function nextYear()
    {
        $this->date = Carbon::parse($this->date)->addYear();
        $this->ano = Carbon::parse($this->date)->year;
    }

    public function toggleShowMonth()
    {
        $this->showMonth = !$this->showMonth;
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
            'situacao',
            'data',
            'descricao',
            'categoria',
            'valor',
        ]);
    }

    public function render()
    {
        $startDate = Carbon::parse($this->date)->startOfMonth();
        $endDate = Carbon::parse($this->date)->endOfMonth();
        $transacoes = Auth::user()->empresa()->transacoes()
            ->whereBetween('data_vencimento', [$startDate, $endDate])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->paginate);
        $this->resetPage();
        return view('livewire.transacoes', compact('transacoes'));
    }
}
