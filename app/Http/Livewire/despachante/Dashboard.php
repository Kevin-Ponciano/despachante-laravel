<?php

namespace App\Http\Livewire\despachante;

use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = ['$refresh'];

    public function render()
    {
        $qtdProcessosAbertos = \Auth::user()->despachante->pedidosProcessos()->where('pedidos.status', 'ab')->count();
        $qtdProcessosRetornados = \Auth::user()->despachante->pedidosProcessos()->where('pedidos.status', 'ab')->where('pedidos.retorno_pendencia', 1)->count();
        $qtdProcessosEmAndamento = \Auth::user()->despachante->pedidosProcessos()->where('pedidos.status', 'ea')->count();
        $qtdProcessosPendentes = \Auth::user()->despachante->pedidosProcessos()->where('pedidos.status', 'pe')->count();
        $qtdAtpvsAbertos = \Auth::user()->despachante->pedidosAtpvs()->where('pedidos.status', 'ab')->count();
        $qtdAtpvsRetornados = \Auth::user()->despachante->pedidosAtpvs()->where('pedidos.status', 'ab')->where('pedidos.retorno_pendencia', 1)->count();
        $qtdAtpvsEmAndamento = \Auth::user()->despachante->pedidosAtpvs()->where('pedidos.status', 'ea')->count();
        $qtdAtpvsPendentes = \Auth::user()->despachante->pedidosAtpvs()->where('pedidos.status', 'pe')->count();
        $qtdAtpvsSolicitadoCancelamento = \Auth::user()->despachante->pedidosAtpvs()->where('pedidos.status', 'sc')->count();

        return view('livewire.despachante.dashboard', compact(
            'qtdProcessosAbertos',
            'qtdProcessosRetornados',
            'qtdProcessosEmAndamento',
            'qtdProcessosPendentes',
            'qtdAtpvsAbertos',
            'qtdAtpvsRetornados',
            'qtdAtpvsEmAndamento',
            'qtdAtpvsPendentes',
            'qtdAtpvsSolicitadoCancelamento',
        ))->layout('layouts.despachante');
    }
}
