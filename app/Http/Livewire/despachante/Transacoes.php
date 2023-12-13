<?php

namespace App\Http\Livewire\despachante;

use App\Traits\FunctionsHelpers;
use Auth;
use Carbon\Carbon;
use http\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Transacoes extends Component
{
    use WithPagination;

    public $search;
    public $paginate = 10;
    public $tipo;
    public $situacao;
    public $data;
    public $descricao;
    public $categoria;
    public $valor;

    public $date;

    public $mes;
    public $ano;
    public $saldoReceitas;
    public $saldoDespesas;
    public $balanco;
    public $saldoPg;
    public $saldoPe;
    public $total;

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
        $this->setTipoWithUrl();
    }

    private function setTipoWithUrl()
    {
        $url = url()->current();
        $url = explode('/', $url);
        $url = end($url);
        if ($url == 'receitas') {
            $this->tipo = 'in';
        } elseif ($url == 'despesas') {
            $this->tipo = 'out';
        } else {
            $this->tipo = null;
        }
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

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

    }

    public function next()
    {
        if ($this->showMonth) {
            $this->nextMonth();
        } else {
            $this->nextYear();
        }

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

    public function setMonth($month)
    {
        $this->date = Carbon::parse($this->date)->month($month);
        $this->mes = Carbon::parse($this->date)->translatedFormat('F');
        $this->ano = Carbon::parse($this->date)->year;
        $this->showMonth = true;
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
            ->where('tipo', 'like', "%{$this->tipo}%")
            ->whereBetween('data_vencimento', [$startDate, $endDate])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->paginate);
        if ($this->tipo) {
            $this->calculateTotal($transacoes);
        }else{
            $this->calculateBalance($transacoes);
        }
        $this->resetPage();
        return view('livewire.transacoes', compact('transacoes'));
    }

    private function calculateBalance($transacoes)
    {
        $saldoReceitas = $transacoes->where('tipo', 'in')->whereIn('status', ['pe', 'pg', 'at'])->sum('valor');
        $saldoDespesas = $transacoes->where('tipo', 'out')->whereIn('status', ['pe', 'pg', 'at'])->sum('valor');
        $balanco = $saldoReceitas - $saldoDespesas;

        $this->saldoReceitas = number_format($saldoReceitas, 2, ',', '.');
        $this->saldoDespesas = number_format($saldoDespesas, 2, ',', '.');
        $this->balanco = number_format($balanco, 2, ',', '.');
    }

    private function calculateTotal($transacoes)
    {
        $saldoPg = $transacoes->where('status', 'pg')->sum('valor');
        $saldoPe = $transacoes->where('status', 'pe')->sum('valor');
        $total = $saldoPg + $saldoPe;

        $this->saldoPg = number_format($saldoPg, 2, ',', '.');
        $this->saldoPe = number_format($saldoPe, 2, ',', '.');
        $this->total = number_format($total, 2, ',', '.');
    }
}
