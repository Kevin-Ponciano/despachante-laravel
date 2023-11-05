<?php

namespace App\Http\Livewire\despachante\Relatorios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Throwable;

class Pedidos extends Component
{
    public function geral(Request $request)
    {
        try {
            $data = [];
            $startDate = $request['start_date'];
            $endDate = $request['end_date'];

            $pedidos = Auth::user()->despachante->pedidos()
                ->with(['processo', 'cliente', 'atpv', 'servicos'])
                ->whereBetween('pedidos.created_at', [$startDate, $endDate])
                ->get();
            $servicosList = Auth::user()->despachante->servicos->pluck('nome', 'id')->toArray();

            foreach ($pedidos as $pedido) {
                $pedidoData = [
                    'numero_pedido' => $pedido->numero_pedido,
                    'status' => $pedido->getStatus()[0],
                    'criado_em' => $pedido->created_at->format('y-m-d'),
                    'concluido_em' => $pedido->concluded_at ? $pedido->concluded_at->format('y-m-d') : 'Não concluído',
                    'cliente' => $pedido->cliente->nome,
                    'comprador_nome' => $pedido->comprador_nome,
                    'placa' => $pedido->placa,
                    'valor_placas' => $pedido->processo ? $pedido->processo->preco_placa : 0,
                    'veiculo' => $pedido->veiculo,
                    'honorario' => $pedido->preco_honorario,
                    'tipo' => $pedido->getTipo() . ' ' . $pedido->atpv?->getMovimentacao(),
                ];

                foreach ($servicosList as $servicoId => $servicoNome) {
                    $servicoPedido = $pedido->servicos->where('id', $servicoId)->first();
                    $pedidoData[$servicoNome] = $servicoPedido ? $servicoPedido->pivot->preco : 0;
                }
                $data[] = $pedidoData;
            }

            $servicos = array_values($servicosList);

            return response()->json(['report' => $data, 'servicos' => $servicos]);
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao gerar relatório');
            return response()->json(['report' => [], 'servicos' => []]);
        }
    }

    public function somatorio(Request $request)
    {
        try {
            $startDate = $request['start_date'];
            $endDate = $request['end_date'];
            $filters = $this->transformFilterFields($request->filters);

            $servicosList = Auth::user()->despachante->servicos->pluck('nome', 'id')->toArray();

            $pedidosQuery = Auth::user()->despachante->pedidos()
                ->with(['processo', 'cliente', 'atpv', 'servicos'])
                ->whereBetween('pedidos.created_at', [$startDate, $endDate]);

            foreach ($filters as $filter) {
                $isNegation = filter_var($filter['isNegation'], FILTER_VALIDATE_BOOLEAN);
                if ($filter['column'] === 'cliente') {
                    $method = $isNegation ? 'whereNotIn' : 'whereIn';
                    $pedidosQuery->$method('clientes.nome', $filter['fields']);
                } elseif ($filter['column'] === 'tipo') {
                    foreach ($filter['fields'] as $field) {
                        $method = $isNegation ? 'whereDoesntHave' : 'whereHas';
                        if ($field === 'PROCESSO') {
                            $pedidosQuery->$method('processo');
                        } elseif ($field === 'ATPV') {
                            $pedidosQuery->$method('atpv', function ($query) {
                                $query->whereNull('codigo_crv');
                            });
                        } elseif ($field === 'RENAVE ENTRADA') {
                            $pedidosQuery->$method('atpv', function ($query) {
                                $query->where('movimentacao', 'in');
                            });
                        } elseif ($field === 'RENAVE SAÍDA') {
                            $pedidosQuery->$method('atpv', function ($query) {
                                $query->where('movimentacao', 'out');
                            });
                        }
                    }
                } else {
                    $method = $isNegation ? 'whereNotIn' : 'whereIn';
                    $pedidosQuery->$method('pedidos.' . $filter['column'], $filter['fields']);
                }
            }

            $pedidos = $pedidosQuery->get();

            $clientesTotais = [];
            foreach ($pedidos as $pedido) {
                $clienteNome = $pedido->cliente->nome;
                if (!array_key_exists($clienteNome, $clientesTotais)) {
                    $servicosTotaisCliente = [];
                    foreach ($servicosList as $servicoId => $servicoNome) {
                        $servicosTotaisCliente['total_preco_' . $servicoNome] = 0;
                        $servicosTotaisCliente['total_quantidade_' . $servicoNome] = 0;
                    }
                    $clientesTotais[$clienteNome] = array_merge([
                        'nomeCliente' => $clienteNome,
                        'total_preco_processo' => 0,
                        'total_quantidade_processo' => 0,
                        'total_preco_atpv' => 0,
                        'total_quantidade_atpv' => 0,
                        'total_preco_renave_entrada' => 0,
                        'total_quantidade_renave_entrada' => 0,
                        'total_preco_renave_saida' => 0,
                        'total_quantidade_renave_saida' => 0,
                        'total_preco_placa' => 0,
                        'total_quantidade_placa' => 0,
                    ], $servicosTotaisCliente);
                }

                $tipo = strtolower($pedido->getTipo2());
                $clientesTotais[$clienteNome]['total_preco_' . $tipo] += $pedido->preco_honorario;
                $clientesTotais[$clienteNome]['total_quantidade_' . $tipo] += 1;

                if ($tipo === 'processo') {
                    $clientesTotais[$clienteNome]['total_preco_placa'] += $pedido->processo->preco_placa;
                    $clientesTotais[$clienteNome]['total_quantidade_placa'] += $pedido->processo->qtd_placas;
                }

                foreach ($pedido->servicos as $servico) {
                    $servicoId = $servico->id;
                    $servicoNome = $servicosList[$servicoId];
                    $servicoPreco = $servico->pivot->preco;
                    $clientesTotais[$clienteNome]['total_preco_' . $servicoNome] += $servicoPreco;
                    $clientesTotais[$clienteNome]['total_quantidade_' . $servicoNome] += 1;
                }
            }

            $clientesTotaisList = array_values($clientesTotais);

            return response()->json(['report' => $clientesTotaisList, 'servicos' => array_values($servicosList)]);
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao gerar relatório');
            return response()->json(['report' => [], 'servicos' => []]);
        }
    }

    private function transformFilterFields($filters)
    {
        if (!$filters) {
            return [];
        }
        $fieldMappings = [
            'Aberto' => 'ab',
            'Concluído' => 'co',
            'Cancelamento Realizado' => 'co',
            'Em Andamento' => 'ea',
            'Solicitado Cancelamento' => 'sc',
            'Excluído' => 'ex',
            'Pendente' => 'pe',
            'Retorno de Pendência' => 'rp',
        ];

        foreach ($filters as $key => $filter) {
            foreach ($filter['fields'] as $fieldKey => $fieldValue) {
                if (isset($fieldMappings[$fieldValue])) {
                    $filters[$key]['fields'][$fieldKey] = $fieldMappings[$fieldValue];
                }
            }
        }

        return $filters;
    }

    public function pendencias()
    {
        $data = [];

        $pedidos = Auth::user()->despachante->pedidos()->where('pedidos.status', 'pe')
            ->with(['processo', 'cliente', 'atpv', 'servicos', 'pendencias'])
            ->get();

        foreach ($pedidos as $pedido) {
            $pedidoData = [
                'numero_pedido' => $pedido->numero_pedido,
                'status' => $pedido->getStatus()[0],
                'criado_em' => $pedido->created_at->format('y-m-d'),
                'tipo' => $pedido->getTipo() . ' ' . $pedido->atpv?->getMovimentacao(),
                'cliente' => $pedido->cliente->nome,
                'comprador_nome' => $pedido->comprador_nome,
                'placa' => $pedido->placa,
                'veiculo' => $pedido->veiculo,
                'pendencias' => implode(', ', $pedido->pendencias->where('status', 'pe')->pluck('nome')->toArray()),
            ];

            $data[] = $pedidoData;
        }
        return response()->json(['report' => $data, 'servicos' => []]);
    }

    public function render()
    {
        return view('livewire.despachante.relatorios.pedidos');
    }
}
