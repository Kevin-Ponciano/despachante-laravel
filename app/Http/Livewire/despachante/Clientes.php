<?php

namespace App\Http\Livewire\despachante;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Clientes extends Component
{
    public function dataTable()
    {
        $data = [];
        $clientes = Auth::user()->despachante->clientes;
        foreach ($clientes as $cliente) {
            $data[] = [
                'numero_cliente' => $cliente->numero_cliente,
                'nome' => $cliente->nome,
                'status' => $cliente->status,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function render()
    {
        return view('livewire.despachante.clientes')
            ->layout('layouts.despachante');
    }
}
