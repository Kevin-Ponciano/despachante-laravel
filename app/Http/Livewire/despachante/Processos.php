<?php

namespace App\Http\Livewire\despachante;

use App\Models\Processo;
use Livewire\Component;

class Processos extends Component
{
    public $processos;

    public function render()
    {
        $this->processos = Processo::all();
        return view('livewire.despachante.processos')
            ->layout('layouts.despachante');
    }
}
