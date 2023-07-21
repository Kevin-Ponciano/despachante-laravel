<?php

namespace App\Http\Livewire\despachante;

use App\Models\Processo;
use Livewire\Component;

class Processos extends Component
{
    public $processos;

    public function toRedirect($id)
    {
        return redirect()->route('despachante.processos.show', $id);
    }
    public function render()
    {
        $this->processos = Processo::all();
        return view('livewire.despachante.processos')
            ->layout('layouts.despachante');
    }
}
