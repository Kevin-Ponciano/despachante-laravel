<?php

namespace App\Traits\transacoes;


use App\Models\Scopes\SoftDeleteScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait Recorrencias
{
    private function verifyCreateTransacaoFixa($startDate, $endDate, $isFiltering = false)
    {
        if ($isFiltering) {
            $transacoesFixas = Auth::user()->empresa()->transacoesFixas()
                ->where('tipo', 'like', "%{$this->tipo}%")
                ->whereBetween('data_vencimento', [$startDate, $endDate])
                ->with('transacaoOriginal.transacoes')
                ->get();
        } else {
            $transacoesFixas = Auth::user()->empresa()->transacoesFixas()
                ->where('tipo', 'like', "%{$this->tipo}%")
                ->where('data_vencimento', '<=', $startDate)
                ->with('transacaoOriginal.transacoes')
                ->get();
        }

        foreach ($transacoesFixas as $transacaoFixa) {
            if ($isFiltering) {
                $meses = $startDate->diffInMonths($endDate);
                for ($i = 0; $i <= $meses; $i++) {
                    $mesInicio = Carbon::parse($startDate)->addMonths($i)->startOfMonth();
                    $mesFim = (clone $mesInicio)->endOfMonth();

                    $transacoes = $this->getTransacoes($transacaoFixa, $mesInicio, $mesFim);
                    if ($transacoes->isEmpty()) {
                        $this->createTransacao($transacaoFixa, $mesInicio);
                    }
                }
            } else {
                $transacoes = $this->getTransacoes($transacaoFixa, $startDate, $endDate);
                if ($transacoes->isEmpty()) {
                    $this->createTransacao($transacaoFixa, Carbon::parse($startDate));
                }
            }
        }
    }

    private function getTransacoes($transacaoFixa, $startDate, $endDate)
    {
        return $transacaoFixa->transacaoOriginal
            ->transacoes()->withoutGlobalScope(SoftDeleteScope::class)
            ->whereBetween('data_vencimento', [$startDate, $endDate])
            ->get();
    }

    private function createTransacao($transacaoFixa, $date)
    {
        $day = Carbon::parse($transacaoFixa->data_vencimento)->day;
        Auth::user()->empresa()->transacoes()->create([
            'transacao_original_id' => $transacaoFixa->transacao_original_id,
            'tipo' => $transacaoFixa->tipo,
            'categoria_id' => $transacaoFixa->categoria_id,
            'valor' => $transacaoFixa->valor,
            'status' => 'pe',
            'data_vencimento' => $date->day($day),
            'descricao' => $transacaoFixa->descricao,
            'observacao' => $transacaoFixa->observacao,
            'recorrencia' => 'fx',
        ]);
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

}
