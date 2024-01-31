<?php

namespace App\Http\Livewire\despachante;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Throwable;

class Usuarios extends Component
{
    public function dataTable()
    {
        try {
            $data = [];
            $usuarios = Auth::user()->despachante->users()->where('id', '!=', Auth::user()->id)->get();
            foreach ($usuarios as $usuario) {
                $data[] = [
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'email' => $usuario->email,
                    'status' => $usuario->status,
                ];
            }

            return response()->json([
                'data' => $data,
            ]);
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao carregar usuários.');

            return response()->json([
                'data' => [],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.despachante.usuarios');
    }
}
