<?php

namespace App\Http\Livewire\despachante;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.despachante.dashboard')
            ->layout('layouts.despachante');
    }
}
