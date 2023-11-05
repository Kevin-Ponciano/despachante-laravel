<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SearchPedidoController extends Controller
{
    public function index($id)
    {
        $pedido = Auth::user()->empresa()->pedidos()->with('processo', 'atpv')->where('numero_pedido', $id)->firstOrFail();
        $route = null;
        if ($pedido->processo) {
            $route = Auth::user()->isDespachante() ? 'despachante.processos.show' : (Auth::user()->isCliente() ? 'cliente.processos.show' : null);
        } elseif ($pedido->atpv) {
            $route = Auth::user()->isDespachante() ? 'despachante.atpvs.show' : (Auth::user()->isCliente() ? 'cliente.atpvs.show' : null);
        }
        if ($route) {
            return redirect()->route($route, $pedido->numero_pedido);
        } else {
            \Log::error('Rota não encontrada para o pedido '.$pedido->numero_pedido);
            abort(404);
        }
    }
}
