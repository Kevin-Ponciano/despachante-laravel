<?php

namespace App\Http\Livewire\despachante;

use Livewire\Component;

class UsuarioNovo extends Component
{
    public function render()
    {
        return view('livewire.despachante.usuario-novo')
            ->layout('layouts.despachante');
    }
}
