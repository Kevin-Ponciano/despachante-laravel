<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = ['$refresh'];

    public function render()
    {
        $qtdProcessosAbertos = Auth::user()->empresa()->pedidosProcessos()->where('pedidos.status', 'ab')->count();
        $qtdProcessosRetornados = Auth::user()->empresa()->pedidosProcessos()->where('pedidos.status', 'rp')->count();
        $qtdProcessosEmAndamento = Auth::user()->empresa()->pedidosProcessos()->where('pedidos.status', 'ea')->count();
        $qtdProcessosPendentes = Auth::user()->empresa()->pedidosProcessos()->where('pedidos.status', 'pe')->count();
        $qtdAtpvsAbertos = Auth::user()->empresa()->pedidosAtpvs()->where('pedidos.status', 'ab')->count();
        $qtdAtpvsRetornados = Auth::user()->empresa()->pedidosAtpvs()->where('pedidos.status', 'rp')->count();
        $qtdAtpvsEmAndamento = Auth::user()->empresa()->pedidosAtpvs()->where('pedidos.status', 'ea')->count();
        $qtdAtpvsPendentes = Auth::user()->empresa()->pedidosAtpvs()->where('pedidos.status', 'pe')->count();
        $qtdAtpvsSolicitadoCancelamento = Auth::user()->empresa()->pedidosAtpvs()->where('pedidos.status', 'sc')->count();


        $qtdProcessosDisponivelDownload = 0;
        $qtdAtpvsDisponivelDownload = 0;
        if (Auth::user()->isCliente()) {
            $processosWithArquivos = Auth::user()->empresa()->pedidosProcessos()->with('arquivos')->where('pedidos.status', '!=', 'ex');
            foreach ($processosWithArquivos->get() as $processo) {
                if ($processo->arquivos->where('folder', 'cod_crlv')->count() > 0) {
                    $qtdProcessosDisponivelDownload++;
                }
            }
            $atpvsWithArquivos = Auth::user()->empresa()->pedidosAtpvs()->with('arquivos')->where('pedidos.status', '!=', 'ex');
            foreach ($atpvsWithArquivos->get() as $atpv) {
                if ($atpv->arquivos->where('folder', 'atpv')->count() > 0 || $atpv->arquivos->where('folder', 'renave/cliente')->count() > 0) {
                    $qtdAtpvsDisponivelDownload++;
                }
            }
        }


        return view('livewire.dashboard', compact(
            'qtdProcessosAbertos',
            'qtdProcessosRetornados',
            'qtdProcessosEmAndamento',
            'qtdProcessosPendentes',
            'qtdProcessosDisponivelDownload',
            'qtdAtpvsAbertos',
            'qtdAtpvsRetornados',
            'qtdAtpvsEmAndamento',
            'qtdAtpvsPendentes',
            'qtdAtpvsSolicitadoCancelamento',
            'qtdAtpvsDisponivelDownload'
        ));
    }
}
