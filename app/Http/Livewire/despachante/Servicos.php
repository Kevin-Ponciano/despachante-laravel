<?php

namespace App\Http\Livewire\despachante;

use App\Traits\FunctionsHelpers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Throwable;

class Servicos extends Component
{
    use FunctionsHelpers;
    public function dataTable()
    {
        try {
            $data = [];
            $servicos = Auth::user()->despachante->servicos->sortBy('nome');
            foreach ($servicos as $servico) {
                $data[] = [
                    'id' => $servico->id,
                    'nome' => $servico->nome,
                    'preco' => $this->regexMoneyToView($servico->preco),
                    'created_at' => $servico->getCreatedAt(),
                ];
            }

            return response()->json([
                'data' => $data,
            ]);
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao carregar serviços.');

            return response()->json([
                'data' => [],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.despachante.servicos');
    }
}
