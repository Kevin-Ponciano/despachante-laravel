<?php

namespace App\Http\Livewire\despachante;

use App\Models\Pedido;
use Auth;
use Livewire\Component;
use Illuminate\Http\Request;

class RelatorioPedidos extends Component
{
    public function data(Request $request)
    {
        $data = [];
        $startDate = $request->start_date ?? now()->subDays(30);
        $endDate = $request->end_date ?? now();

        $pedidos = Auth::user()->despachante->pedidos()->with(['processo', 'cliente', 'atpv', 'servicos'])->whereBetween('pedidos.created_at', [$startDate, $endDate])->get();
        $servicosList = Auth::user()->despachante->servicos->pluck('nome', 'id')->toArray();

        foreach ($pedidos as $pedido) {
            $pedidoData = [
                'numero_pedido' => $pedido->numero_pedido,
                'status' => $pedido->getStatus()[0],
                'criado_em' => $pedido->created_at->format('y-m-d'),
                'concluido_em' => $pedido->concluded_at ? $pedido->concluded_at : 'Não concluído',
                'cliente' => $pedido->cliente->nome,
                'comprador_nome' => $pedido->comprador_nome,
                'placa' => $pedido->placa,
                'valor_placas' => $pedido->processo ? $pedido->processo->preco_placa : 0,
                'veiculo' => $pedido->veiculo,
                'honorario' => $pedido->preco_honorario,
                'tipo' => $pedido->getTipo() . ' ' . $pedido->atpv?->getMovimentacao(),
            ];

            // Adicionando serviços e preços ao pedido
            foreach ($servicosList as $servicoId => $servicoNome) {
                $servicoPedido = $pedido->servicos->where('id', $servicoId)->first();
                $pedidoData[$servicoNome] = $servicoPedido ? $servicoPedido->pivot->preco : 0;
            }
            $data[] = $pedidoData;
        }

        $servicos = array_values($servicosList);
        return response()->json(['report' => $data, 'servicos' => $servicos]);
    }

    public function render()
    {
        return view('livewire.despachante.relatorio-pedidos');
    }
}
