<?php

namespace App\Http\Livewire\despachante;

use App\Models\Pedido;
use Livewire\Component;

class RelatorioPedidos extends Component
{
    public $pedidos;
    public $teste = 'teste';

    public function teste()
    {
        $this->teste = 'update livewire';
        debug($this->teste);
        $this->emit('teste');
    }

    public function render()
    {
        $this->pedidos = Pedido::all();
        return view('livewire.despachante.relatorio-pedidos');
    }
}
