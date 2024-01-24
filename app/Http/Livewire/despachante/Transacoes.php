<?php

namespace App\Http\Livewire\despachante;

use App\Models\Scopes\SoftDeleteScope;
use App\Traits\FunctionsHelpers;
use Arr;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Transacoes extends Component
{
    use WithPagination;
    use FunctionsHelpers;

    public $search, $paginate = 10, $sortField = 'data_vencimento', $sortDirection = 'desc', $iconDirection = 'up';
    public $tipo;
    public $categorias = [];
    public $date, $mes, $ano, $valor;
    public $saldoReceitas, $saldoDespesas, $balanco;
    public $saldoPago, $saldoPendente, $total;
    public $transacao = [
        'recorrente_periodo' => 'Months',
        'recorrente_vezes' => 2,
        'status' => 'pe',
        'descricao' => '',
        'valor' => '',
        'recorrencia' => 'n/a',
    ];
    public $data_vencimento, $fixa = false, $recorrente = false, $situacao, $recorrenteOpcao = 'this';
    public $showMonth = true, $creating = false, $color = null;
    public $startDateFilter, $endDateFilter, $categoriasIdFilter, $situacaoFilter = 'pg', $recorrenciaFilter, $tipoFilter,
        $filters = [], $filtering = false, $filterBag = [];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        '$refresh',
        'setTipo',
    ];

    protected $rules = [
        'valor' => 'required|numeric|min:0.01',
        'transacao.recorrente_vezes' => 'numeric|min:2',
    ];

    protected $messages = [
        'valor.required' => 'Informe um valor válido.',
        'valor.numeric' => 'Informe um valor válido.',
        'valor.min' => 'Informe um valor válido.',
        'transacao.recorrente_vezes.numeric' => 'Informe um numero maior que 1.',
        'transacao.recorrente_vezes.min' => 'Informe um numero maior que 1.',
    ];

    public function mount()
    {
        $this->date = Carbon::now();
        $this->mes = $this->date->translatedFormat('F');
        $this->ano = $this->date->year;
        $this->setTipoWithUrl();
        $this->categorias = Auth::user()->empresa()->categorias()->get();
        $this->switchSituacao();
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

    public function switchSituacao()
    {
        if ($this->tipo == 'in') {
            $this->situacao = $this->situacao == "Não foi recebida" ? "Foi recebida" : "Não foi recebida";
            $this->transacao['status'] = $this->situacao == "Não foi recebida" ? "pe" : "pg";
        } elseif ($this->tipo == 'out') {
            $this->situacao = $this->situacao == "Não foi paga" ? "Foi paga" : "Não foi paga";
            $this->transacao['status'] = $this->situacao == "Não foi paga" ? "pe" : "pg";
        }
    }

    public function handleRecorrencia($recorrencia)
    {
        if ($recorrencia === 'fx') {
            $this->recorrente = false;
        } elseif ($recorrencia === 'rr') {
            $this->fixa = false;
            $this->transacao['recorrente_vezes'] = 2;
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
        $this->situacao = $tipo == 'in' ? 'Não foi recebida' : 'Não foi paga';
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

    public function edit($id)
    {
        $this->creating = false;
        $this->recorrenteOpcao = 'this';
        $transacao = Auth::user()->empresa()->transacoes()->find($id);
        $this->color = $transacao->tipo === 'in' ? 'success' : 'danger';
        $this->transacao['id'] = $transacao->id;
        $this->transacao['valor'] = $this->regexMoneyToView($transacao->valor);
        $this->transacao['pago'] = $transacao->status === 'pg';
        $this->transacao['status'] = $transacao->status;
        $tipo = $transacao->tipo;
        if ($tipo === 'in') {
            $this->situacao = $transacao->status === 'pg' ? 'Foi recebida' : 'Não foi recebida';
        } elseif ($tipo === 'out') {
            $this->situacao = $transacao->status === 'pg' ? 'Foi paga' : 'Não foi paga';
        }
        $this->transacao['descricao'] = $transacao->descricao;
        $this->transacao['categoria_id'] = $transacao->categoria_id;
        $this->transacao['observacao'] = $transacao->observacao;
        $this->transacao['data_pagamento'] = $transacao->data_pagamento;

        $this->recorrente = $transacao->recorrencia !== 'n/a';
        $data_vencimento = Carbon::parse($transacao->data_vencimento)->toDateTimeString();

        $this->emit('edit', [
            'data_vencimento' => $data_vencimento,
            'categoria_id' => $transacao->categoria_id,
        ]);
    }

    public function destroy()
    {
        $transacao = Auth::user()->empresa()->transacoes()->find($this->transacao['id']);
        switch ($this->recorrenteOpcao) {
            case 'pendentes':
                if ($transacao->recorrencia === 'rr') {
                    $this->deleteAndRelinkControleRepeticoes($transacao);
                } elseif ($transacao->recorrencia === 'fx') {
                    $transacoes = $transacao->transacaoOriginal->transacoes()
                        ->where('status', 'pe');
                    $transacao->transacaoOriginal->fixa()->delete();
                    $transacoes->delete();
                }
                break;
            case 'all':
                if ($transacao->recorrencia === 'rr') {
                    $transacoes = $transacao->transacaoOriginal->transacoes();
                    $transacoes->delete();
                } elseif ($transacao->recorrencia === 'fx') {
                    $transacao->transacaoOriginal->transacoes()->delete();
                }
                break;
            default:
                if ($transacao->recorrencia === 'rr') {
                    $this->deleteAndRelinkControleRepeticoes($transacao, true);
                } elseif ($transacao->recorrencia === 'fx') {
                    if ($transacao->id === $transacao->transacao_original_id &&
                        $transacao->transacaoOriginal->transacoes()->count() > 1) {
                        $transacaoOriginal = $transacao->transacaoOriginal;
                        $transacaoValida = $transacaoOriginal->transacoes()->where('id', '!=', $transacao->id)
                            ->orderBy('id', 'asc')->first();
                        $transacaoOriginal->transacoes()->where('id', '!=', $transacao->id)->update([
                            'transacao_original_id' => $transacaoValida->id,
                        ]);
                        $transacaoOriginal->fixa()->update(['transacao_original_id' => $transacaoValida->id]);
                    }
                    $transacao->update(['status' => 'ex']);
                }
        }
        $this->recorrenteOpcao = 'this';
        $this->emit('$refresh');
        $this->emit('success', ['message' => 'Transação excluida com sucesso.']);
    }

    private function deleteAndRelinkControleRepeticoes($transacao, $This = false): void
    {
        $transacaoAtual = $transacao;
        $transacaoValida = null;
        while ($transacaoAtual) {
            if ($This) {
                if ($transacaoAtual->id === $transacao->id) {
                    $this->excluirTransacaoEAtualizarVinculos($transacaoAtual);
                } else {
                    $transacaoValida = $transacaoAtual;
                }
            } else {
                if ($transacaoAtual->status === 'pe' || $transacaoAtual->id === $transacao->id) {
                    $this->excluirTransacaoEAtualizarVinculos($transacaoAtual);
                } else {
                    $transacaoValida = $transacaoAtual;
                }
            }
            $transacaoAtual = $transacaoAtual->controleRepeticao->transacaoPosterior;
        }
        $this->relinkControleRepeticoes($transacaoValida);
    }

    private function excluirTransacaoEAtualizarVinculos($transacaoAtual): void
    {
        $transacaoAnterior = $transacaoAtual->controleRepeticao->transacaoAnterior;
        $transacaoPosterior = $transacaoAtual->controleRepeticao->transacaoPosterior;

        if ($transacaoAnterior) {
            $transacaoAnterior->controleRepeticao->update([
                'transacao_posterior_id' => $transacaoAtual->controleRepeticao->transacao_posterior_id,
            ]);
        }

        if ($transacaoPosterior) {
            $transacaoPosterior->controleRepeticao->update([
                'transacao_anterior_id' => $transacaoAtual->controleRepeticao->transacao_anterior_id,
            ]);
        }
        $transacaoAtual->delete();
    }

    public function update()
    {
        $this->valor = $this->regexMoney($this->transacao['valor'] ?? null);
        $this->validate();
        $descricao = $this->transacao['descricao'] === '' ? Auth::user()->empresa()->categorias()
            ->find($this->transacao['categoria_id'])->nome : $this->transacao['descricao'];

        $transacao = Auth::user()->empresa()->transacoes()->find($this->transacao['id']);
        if ($this->recorrenteOpcao === 'pendentes') {
            if ($transacao->recorrencia === 'rr') {
                $this->updatePendenteOption($transacao, $descricao);
                while ($transacao) {
                    if ($transacao->status === 'pe')
                        $this->updatePendenteOption($transacao, $descricao);
                    $transacao = $transacao->controleRepeticao->transacaoPosterior;
                }
            } elseif ($transacao->recorrencia === 'fx') {
                $this->updatePendenteOption($transacao, $descricao);
                $transacoes = $transacao->transacaoOriginal->transacoes()->where('recorrencia', 'fx')
                    ->where('status', 'pe');
                $this->updatePendenteOption($transacoes, $descricao);
                $trasacaoFixa = $transacao->transacaoOriginal->fixa();
                $this->updatePendenteOption($trasacaoFixa, $descricao);
            }
        } elseif ($this->recorrenteOpcao === 'all') {
            if ($transacao->recorrencia === 'rr') {
                $transacoes = $transacao->transacaoOriginal->transacoes();
                $this->updateAllOption($transacoes, $descricao);
            } elseif ($transacao->recorrencia === 'fx') {
                $transacoes = $transacao->transacaoOriginal->transacoes();
                $this->updateAllOption($transacoes, $descricao);
                $trasacaoFixa = $transacao->transacaoOriginal->fixa();
                $this->updateAllOption($trasacaoFixa, $descricao);
            }
        } else {
            $transacao->update([
                'categoria_id' => $this->transacao['categoria_id'],
                'valor' => $this->valor,
                'status' => $this->transacao['status'],
                'data_vencimento' => $this->data_vencimento,
                'data_pagamento' => $this->transacao['status'] == 'pg' ? $this->data_vencimento : null,
                'descricao' => $descricao,
                'observacao' => $this->transacao['observacao'],
            ]);
        }

        $this->emit('$refresh');
        $this->emit('success', ['message' => 'Transação atualizada com sucesso.']);
    }

    private function updatePendenteOption($transacao, $descricao)
    {
        $transacao->update([
            'categoria_id' => $this->transacao['categoria_id'],
            'valor' => $this->valor,
            'descricao' => $descricao,
            'observacao' => $this->transacao['observacao'],
        ]);
    }

    private function updateAllOption($transacao, $descricao)
    {
        $transacao->update([
            'categoria_id' => $this->transacao['categoria_id'],
            'descricao' => $descricao,
            'observacao' => $this->transacao['observacao'],
        ]);
    }

    public function delete($id)
    {
        $transacao = Auth::user()->empresa()->transacoes()->find($id);
        $this->color = $transacao->tipo === 'in' ? 'success' : 'danger';
        $this->transacao['id'] = $transacao->id;
        $this->transacao['descricao'] = $transacao->descricao;
        $this->transacao['valor'] = $this->regexMoneyToView($transacao->valor);
        $this->transacao['recorrencia'] = $transacao->recorrencia;
        $this->recorrenteOpcao = 'this';
        $this->recorrente = $transacao->recorrencia !== 'n/a';
    }

    private function relinkControleRepeticoes($transacaoValida): void
    {
        if ($transacaoValida && !$transacaoValida->transacaoOriginal) {
            $transacaoMaisAntiga = $transacaoValida;

            while ($transacaoMaisAntiga->controleRepeticao->transacaoAnterior) {
                $transacaoMaisAntiga = $transacaoMaisAntiga->controleRepeticao->transacaoAnterior;
            }

            $idTransacaoMaisAntiga = $transacaoMaisAntiga->id;

            while ($transacaoMaisAntiga) {
                $transacaoMaisAntiga->update(['transacao_original_id' => $idTransacaoMaisAntiga]);
                $transacaoMaisAntiga->controleRepeticao->update(['transacao_original_id' => $idTransacaoMaisAntiga]);
                $transacaoMaisAntiga = $transacaoMaisAntiga->controleRepeticao->transacaoPosterior;
            }
            #TODO: Refatorar corrigindo a posicao e o total de repeticoes
        }
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

    public function resetFilters()
    {
        $this->reset([
            'startDateFilter',
            'endDateFilter',
            'categoriasIdFilter',
            'situacaoFilter',
            'recorrenciaFilter',
            'tipoFilter',
            'filters',
            'filtering',
        ]);
    }

    public function clearInputs()
    {
        $this->reset([
            'transacao',
            'data_vencimento',
            'fixa',
            'recorrente',
            'situacao',
        ]);
        $this->switchSituacao();
        $this->creating = true;
        $this->emit('showModal');
        $this->resetErrorBag();
    }

    public function render()
    {
        $startDate = Carbon::parse($this->date)->startOfMonth();
        $endDate = Carbon::parse($this->date)->endOfMonth();
        $this->verifyCreateTransacaoFixa($startDate, $endDate);
        $transacoes = Auth::user()->empresa()->transacoes();
        if ($this->filtering) {
            $transacoes = $this->filter($transacoes);
        } else {
            $transacoes = $transacoes
                ->where('status', '!=', 'ex')
                ->where('tipo', 'like', "%{$this->tipo}%")
                ->whereBetween('data_vencimento', [$startDate, $endDate]);
        }
        $transacoes = $transacoes
            ->with('transacaoOriginal.transacoes')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->paginate);
        if ($this->tipo) {
            $this->calculateTotal($transacoes);
        } else {
            $this->calculateBalance($transacoes);
        }
        $this->resetPage();

        $this->startDateFilter = $startDate->format('Y-m-d');
        $this->endDateFilter = $endDate->format('Y-m-d');
        debug($this->filters);
        return view('livewire.transacoes', compact('transacoes'));
    }

    private function verifyCreateTransacaoFixa($startDate, $endDate)
    {
        $transacoesFixas = Auth::user()->empresa()->transacoesFixas()
            ->where('tipo', 'like', "%{$this->tipo}%")
            ->where('data_vencimento', '<=', $startDate)
            ->with('transacaoOriginal.transacoes')
            ->get();

        foreach ($transacoesFixas as $transacaoFixa) {
            $transacoes = $transacaoFixa->transacaoOriginal
                ->transacoes()->withoutGlobalScope(SoftDeleteScope::class)
                ->whereBetween('data_vencimento', [$startDate, $endDate])
                ->get();

            if ($transacoes->isEmpty()) {
                $day = Carbon::parse($transacaoFixa->data_vencimento)->day;
                Auth::user()->empresa()->transacoes()->create([
                    'transacao_original_id' => $transacaoFixa->transacao_original_id,
                    'tipo' => $this->tipo,
                    'categoria_id' => $transacaoFixa->categoria_id,
                    'valor' => $transacaoFixa->valor,
                    'status' => 'pe',
                    'data_vencimento' => Carbon::parse($startDate)->day($day),
                    'descricao' => $transacaoFixa->descricao,
                    'observacao' => $transacaoFixa->observacao,
                    'recorrencia' => 'fx',
                ]);
            }
        }
    }

    public function create()
    {
        $this->valor = $this->regexMoney($this->transacao['valor'] ?? null);
        $this->validate();

        $recorrencia = $this->fixa ? 'fx' : ($this->recorrente ? 'rr' : 'n/a');
        $categoria_id = $this->transacao['categoria_id'] ?? $this->categorias->first()->id;
        $descricao = $this->transacao['descricao'] === '' ? Auth::user()->empresa()->categorias()
            ->find($categoria_id)->nome : $this->transacao['descricao'];

        $transacao = Auth::user()->empresa()->transacoes()->create([
            'tipo' => $this->tipo,
            'categoria_id' => $categoria_id,
            'valor' => $this->valor,
            'status' => $this->transacao['status'],
            'data_vencimento' => $this->data_vencimento ?? Carbon::now(),
            'data_pagamento' => $this->transacao['status'] == 'pg' ? $this->data_vencimento : null,
            'descricao' => $descricao,
            'observacao' => $this->transacao['observacao'] ?? null,
            'recorrencia' => $recorrencia,
        ]);
        $transacao->update([
            'transacao_original_id' => $transacao->id,
        ]);

        if ($recorrencia === 'rr') {
            $this->createTransacoesRecorrentes($transacao);
        } elseif ($recorrencia === 'fx') {
            $transacao->fixa()->create([
                'tipo' => $this->tipo,
                'despachante_id' => Auth::user()->despachante->id,
                'categoria_id' => $categoria_id,
                'valor' => $this->valor,
                'data_vencimento' => $this->data_vencimento ?? Carbon::now(),
                'descricao' => $descricao,
                'observacao' => $this->transacao['observacao'] ?? null,
            ]);
        }

        $this->emit('$refresh');
        $this->emit('success', ['message' => 'Transação criada com sucesso.']);
    }

    private function createTransacoesRecorrentes($transacao)
    {
        $repeticoes = $this->transacao['recorrente_vezes'];
        $periodo = $this->transacao['recorrente_periodo'];
        $addPeriodo = 'add' . $periodo;
        $transacao_original_id = $transacao->id;

        $transacao->controleRepeticao()->create([
            'transacao_original_id' => $transacao_original_id,
            'total_repeticoes' => $repeticoes,
        ]);

        $transacao_anterior = $transacao;

        for ($i = 1; $i < $repeticoes; $i++) {
            $transacao = $transacao->replicate()->fill([
                'data_vencimento' => Carbon::parse($transacao->data_vencimento)->$addPeriodo(),
                'data_pagamento' => null,
                'status' => 'pe',
                'transacao_original_id' => $transacao_original_id,
            ]);
            $transacao->save();

            $transacao->controleRepeticao()->create([
                'transacao_anterior_id' => $transacao_anterior->id,
                'transacao_original_id' => $transacao_original_id,
                'posicao' => $i + 1,
                'total_repeticoes' => $repeticoes,
            ]);

            $transacao_anterior->controleRepeticao()->update([
                'transacao_posterior_id' => $transacao->id,
            ]);

            $transacao_anterior = $transacao;
        }
    }

    private function filter($model)
    {
        $startDateFilter = $this->startDateFilter;
        $endDateFilter = $this->endDateFilter;
        $categoriasIdFilter = $this->categoriasIdFilter;
        $situacaoFilter = $this->situacaoFilter;
        $recorrenciaFilter = $this->recorrenciaFilter;
        $tipoFilter = $this->tipo ?: $this->tipoFilter;
        $model
            ->when($startDateFilter && $endDateFilter, function ($query) use ($startDateFilter, $endDateFilter) {
                $this->filters['date']['startDateFilter'] = Carbon::parse($startDateFilter)->format('d/m/Y');
                $this->filters['date']['endDateFilter'] = Carbon::parse($endDateFilter)->format('d/m/Y');
                return $query->whereBetween('data_vencimento', [$startDateFilter, $endDateFilter]);
            })
            ->when($categoriasIdFilter, function ($query) use ($categoriasIdFilter) {
                $this->filters['categorias'] = Auth::user()->empresa()->categorias()->where('status', 'at')
                    ->whereIn('id', $categoriasIdFilter)->get()->toArray();
                return $query->whereIn('categoria_id', $categoriasIdFilter);
            })
            ->when($situacaoFilter, function ($query) use ($situacaoFilter) {
                $this->filters['situacao'] = $situacaoFilter;
                return $query->where('status', $situacaoFilter);
            })
            ->when($recorrenciaFilter, function ($query) use ($recorrenciaFilter) {
                switch ($recorrenciaFilter) {
                    case 'fx':
                        $this->filters['recorrenciaFilter'] = 'fixa';
                        break;
                    case 'rr':
                        $this->filters['recorrenciaFilter'] = 'recorrente';
                        break;
                    case 'n/a':
                        $this->filters['recorrenciaFilter'] = 'não recorrente';
                }
                return $query->where('recorrencia', $recorrenciaFilter);
            })
            ->when($tipoFilter, function ($query) use ($tipoFilter) {
                $this->filters['tipoFilter'] = $tipoFilter === 'in' ? 'receita' : 'despesa';
                return $query->where('tipo', $tipoFilter);
            });

        return $model;
    }

    private function calculateTotal($transacoes)
    {
        $saldoPg = $transacoes->where('status', 'pg')->sum('valor');
        $saldoPe = $transacoes->where('status', 'pe')->sum('valor');
        $total = $saldoPg + $saldoPe;

        $this->saldoPago = number_format($saldoPg, 2, ',', '.');
        $this->saldoPendente = number_format($saldoPe, 2, ',', '.');
        $this->total = number_format($total, 2, ',', '.');
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

    public function removeFilter($key, $value = null)
    {
        switch ($key) {
            case 'date':
                $this->startDateFilter = null;
                $this->endDateFilter = null;
                break;
            case 'categorias':
                $id = $value;
                $this->categoriasIdFilter = Arr::where($this->categoriasIdFilter, function ($value) use ($id) {
                    return $value != $id;
                });
                if (empty($this->categoriasIdFilter))
                    unset($this->filters['categorias']);
                break;
            case 'situacao':
                $this->situacaoFilter = null;
                unset($this->filters['situacao']);
                break;
            case 'recorrenciaFilter':
                $this->recorrenciaFilter = null;
                break;
            case 'tipoFilter':
                $this->tipoFilter = null;
                break;
        }
    }

    public function applyFilter()
    {
        $this->filtering = true;
        # TODO: Usar form 
    }
}
