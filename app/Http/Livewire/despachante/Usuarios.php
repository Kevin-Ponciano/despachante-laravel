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
        if (Auth::user()->role[1] === 'u')
            abort(403, 'Você não tem permissão para acessar esta página.');
        return view('livewire.despachante.usuarios');
    }
}
