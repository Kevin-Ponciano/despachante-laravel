<?php

namespace App\Http\Livewire\despachante;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Throwable;

class Clientes extends Component
{
    public function dataTable()
    {
        try {
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
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao carregar clientes.');
            return response()->json([
                'data' => [],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.despachante.clientes');
    }
}
