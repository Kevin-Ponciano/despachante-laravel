<?php

namespace App\Http\Livewire\cliente;

use App\Models\Cliente;
use Livewire\Component;

class Dashboard extends Component
{
    public $clienteNome;

    public function mount()
    {
        $this->clienteNome = Cliente::find(auth()->user()->cliente_id)->nome;
    }

    public function render()
    {
        return view('livewire.cliente.dashboard')
            ->layout('layouts.cliente');
    }
}
