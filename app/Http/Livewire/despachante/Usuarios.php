<?php

namespace App\Http\Livewire\despachante;

use App\Models\User;
use Livewire\Component;

class Usuarios extends Component
{
    public $usuarios;
    public function render()
    {
        $this->usuarios = User::all();
        return view('livewire.despachante.usuarios')
            ->layout('layouts.despachante');
    }
}
