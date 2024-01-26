<?php

namespace App\Traits\transacoes;


use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait Filter
{
    public $startDateFilter;
    public $endDateFilter;
    public $categoriasIdFilter;
    public $situacaoFilter;
    public $recorrenciaFilter;
    public $tipoFilter;
    public $filters = [];
    public $filtering = false;


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
                $this->filters['recorrenciaFilter'] = $recorrenciaFilter;
                if ($recorrenciaFilter === 'rr')
                    return $query->where('recorrencia', '!=', 'n/a');
                else
                    return $query->where('recorrencia', $recorrenciaFilter);
            })
            ->when($tipoFilter, function ($query) use ($tipoFilter) {
                $this->filters['tipoFilter'] = $tipoFilter === 'in' ? 'receita' : 'despesa';
                return $query->where('tipo', $tipoFilter);
            });

        return $model;
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

    public function applyFilter($filters)
    {
        $this->startDateFilter = $filters['start_date'] ?? null;
        $this->endDateFilter = $filters['end_date'] ?? null;
        $this->categoriasIdFilter = $filters['categorias_id'] ?? null;
        $this->situacaoFilter = $filters['situacao'] ?? null;
        $this->recorrenciaFilter = $filters['recorrencia'] ?? null;
        $this->tipoFilter = $filters['tipo'] ?? null;

        $this->filtering = true;
    }
}
