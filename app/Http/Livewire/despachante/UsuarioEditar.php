<?php

namespace App\Http\Livewire\despachante;

use App\Models\User;
use Livewire\Component;

class UsuarioEditar extends Component
{
    public $nome;
    public $email;
    public $role;

    public function mount($id)
    {
        $usuario = User::find($id);
        $this->nome = $usuario->name;
        $this->email = $usuario->email;
        $this->role = $usuario->role;
    }
    public function changeName()
    {
        debug($this->role);
        $this->emit('savedName');
    }
    public function render()
    {
        return view('livewire.despachante.usuario-editar')
            ->layout('layouts.despachante');
    }
}
