<?php

namespace App\Http\Livewire\despachante;

use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = ['$refresh'];
    
    public function render()
    {
        $qtdProcessosAbertos = \Auth::user()->despachante->pedidosWithProcessos()->where('status', 'ab')->count();
        $qtdProcessosEmAndamento = \Auth::user()->despachante->pedidosWithProcessos()->where('status', 'ea')->count();
        $qtdProcessosPendentes = \Auth::user()->despachante->pedidosWithProcessos()->where('status', 'pe')->count();
        $qtdAtpvsAbertos = \Auth::user()->despachante->pedidosWithAtpvs()->where('status', 'ab')->count();
        $qtdAtpvsEmAndamento = \Auth::user()->despachante->pedidosWithAtpvs()->where('status', 'ea')->count();
        $qtdAtpvsPendentes = \Auth::user()->despachante->pedidosWithAtpvs()->where('status', 'pe')->count();
        $qtdAtpvsSolicitadoCancelamento = \Auth::user()->despachante->pedidosWithAtpvs()->where('status', 'sc')->count();
        return view('livewire.despachante.dashboard', compact(
            'qtdProcessosAbertos',
            'qtdProcessosEmAndamento',
            'qtdProcessosPendentes',
            'qtdAtpvsAbertos',
            'qtdAtpvsEmAndamento',
            'qtdAtpvsPendentes',
            'qtdAtpvsSolicitadoCancelamento',
        ))->layout('layouts.despachante');
    }
}
