<?php

namespace App\Http\Livewire\despachante;

use App\Models\Cliente;
use Livewire\Component;

class Clientes extends Component
{
    public $clientes;
    public $teste = 'ok';

    public function teste()
    {
        $this->teste='teste';
        debug('teste');
        $this->emit('refresh-datatable');
    }
    public function render()
    {
        $this->clientes = Cliente::all();
        return view('livewire.despachante.clientes')
            ->layout('layouts.despachante');
    }
}
