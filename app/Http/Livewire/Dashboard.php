<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = ['$refresh'];
    public $empresa;

    public function mount()
    {
        $this->empresa = Auth::user()->empresa();
    }

    public function render()
    {
        $qtdProcessosAbertos = $this->empresa->pedidosProcessos()->where('pedidos.status', 'ab')->count();
        $qtdProcessosRetornados = $this->empresa->pedidosProcessos()->where('pedidos.status', 'rp')->count();
        $qtdProcessosEmAndamento = $this->empresa->pedidosProcessos()->where('pedidos.status', 'ea')->count();
        $qtdProcessosPendentes = $this->empresa->pedidosProcessos()->where('pedidos.status', 'pe')->count();
        $qtdAtpvsAbertos = $this->empresa->pedidosAtpvs()->where('pedidos.status', 'ab')->count();
        $qtdAtpvsRetornados = $this->empresa->pedidosAtpvs()->where('pedidos.status', 'rp')->count();
        $qtdAtpvsEmAndamento = $this->empresa->pedidosAtpvs()->where('pedidos.status', 'ea')->count();
        $qtdAtpvsPendentes = $this->empresa->pedidosAtpvs()->where('pedidos.status', 'pe')->count();
        $qtdAtpvsSolicitadoCancelamento = $this->empresa->pedidosAtpvs()->where('pedidos.status', 'sc')->count();


        $qtdProcessosDisponivelDownload = 0;
        $qtdAtpvsDisponivelDownload = 0;
        if (Auth::user()->isCliente()) {
            $processosWithArquivos = $this->empresa->pedidosProcessos()->with('arquivos')->where('pedidos.status', '!=', 'ex');
            foreach ($processosWithArquivos->get() as $processo) {
                if ($processo->arquivos->where('folder', 'cod_crlv')->count() > 0) {
                    $qtdProcessosDisponivelDownload++;
                }
            }
            $atpvsWithArquivos = $this->empresa->pedidosAtpvs()->with('arquivos')->where('pedidos.status', '!=', 'ex');
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
