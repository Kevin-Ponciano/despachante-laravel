<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = ['atualizarDashboard'];

    public $empresa;

    public function mount()
    {
        $this->empresa = Auth::user()->empresa();
    }

    public function atualizarDashboard()
    {
        $this->render();
        $this->emit('atualizarDashboardDone');
    }

    public function render()
    {
        $pedidosProcessos = $this->empresa->pedidosProcessos()->whereIn('pedidos.status', ['ab', 'rp', 'ea', 'pe'])->select('pedidos.status')->get();
        $pedidosAtpvs = $this->empresa->pedidosAtpvs()->whereIn('pedidos.status', ['ab', 'rp', 'ea', 'pe', 'sc'])->select('pedidos.status')->get();

        $qtdProcessosAbertos = $pedidosProcessos->where('status', 'ab')->count();
        $qtdProcessosRetornados = $pedidosProcessos->where('status', 'rp')->count();
        $qtdProcessosEmAndamento = $pedidosProcessos->where('status', 'ea')->count();
        $qtdProcessosPendentes = $pedidosProcessos->where('status', 'pe')->count();

        $qtdAtpvsAbertos = $pedidosAtpvs->where('status', 'ab')->count();
        $qtdAtpvsRetornados = $pedidosAtpvs->where('status', 'rp')->count();
        $qtdAtpvsEmAndamento = $pedidosAtpvs->where('status', 'ea')->count();
        $qtdAtpvsPendentes = $pedidosAtpvs->where('status', 'pe')->count();
        $qtdAtpvsSolicitadoCancelamento = $pedidosAtpvs->where('status', 'sc')->count();

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
