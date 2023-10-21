<?php

namespace App\Http\Livewire\despachante;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Usuarios extends Component
{
    public function dataTable()
    {
        $data = [];
        $usuarios = Auth::user()->despachante->users;
        foreach ($usuarios as $usuario) {
            $data[] = [
                'id' => $usuario->id,
                'name' => $usuario->name,
                'email' => $usuario->email,
                'role' => $usuario->getFuncao(),
                'status' => $usuario->status,
            ];
        }
        return response()->json([
            'data' => $data,
        ]);
    }

    public function render()
    {
        return view('livewire.despachante.usuarios');
    }
}
