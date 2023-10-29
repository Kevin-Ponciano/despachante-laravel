<?php

namespace App\Http\Livewire\despachante;

use Auth;
use Livewire\Component;
use Log;
use Throwable;

class Settings extends Component
{

    public $despachante;
    public $despachanteCollection;

    protected $messages = [
        'despachante.email.required' => 'O email é obrigatório.',
        'despachante.email.email' => 'O email deve ser um email válido.',
        'despachante.email.unique' => 'O email informado já está em uso.',
        'despachante.celular.required' => 'O celular é obrigatório.',
    ];

    public function mount()
    {
        $this->despachanteCollection = Auth::user()->despachante()->with('endereco')->get();
        $this->despachante = $this->despachanteCollection->toArray()[0];
    }

    public function update()
    {
        $this->validate([
            'despachante.email' => 'required|email|unique:despachantes,email,' . $this->despachante['id'],
            'despachante.celular' => 'required'
        ]);

        try {
            $this->despachanteCollection[0]->update([
                'email' => $this->despachante['email'],
                'celular' => $this->despachante['celular'],
                'celular_secundario' => $this->despachante['celular_secundario'],
                'site' => $this->despachante['site'],
            ]);
            $this->emit('success', ['message' => 'Dados atualizados com sucesso.']);
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao atualizar dados.');
        }
    }


    public function render()
    {
        return view('livewire.despachante.settings');
    }
}
