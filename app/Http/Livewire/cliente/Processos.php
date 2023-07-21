<?php

namespace App\Http\Livewire\cliente;

use App\Models\Processo;
use Livewire\Component;

class Processos extends Component
{
    public $processos;

    public function toRedirect($id)
    {
        return redirect()->route('cliente.processos.show', $id);
    }
    public function render()
    {
        $this->processos = Processo::all();
        return view('livewire.cliente.processos')
            ->layout('layouts.cliente');
    }
}
