<?php

namespace App\Http\Livewire\despachante;

use Livewire\Component;

class ClienteNovo extends Component
{
    public function render()
    {
        return view('livewire.despachante.cliente-novo')
            ->layout('layouts.despachante');
    }
}
