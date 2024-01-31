<?php

namespace App\Http\Livewire\despachante;

use App\Traits\FunctionsHelpers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Throwable;

class ServicoEditar extends Component
{
    use FunctionsHelpers;

    public $servicos;

    public $servico = [
        'id' => -1,
    ];

    public function mount($id)
    {
        $this->servicos = Auth::user()->despachante->servicos()->orderBy('nome')->get();
        $this->servico['id'] = $id;
        $this->switchServico();
    }

    public function switchServico()
    {
        if ($this->servico['id'] == -1) {
            $this->clearFields();
        } else {
            $servico = $this->servicos->find($this->servico['id']);
            $this->servico['nome'] = $servico->nome;
            $this->servico['preco'] = $this->regexMoneyToView($servico->preco);
            $this->servico['descricao'] = $servico->descricao;
        }
    }

    public function clearFields()
    {
        $this->servico = [
            'id' => -1,
            'nome' => '',
            'preco' => '',
            'descricao' => '',
        ];
    }

    public function createOrUpdate()
    {
        $this->validate([
            'servico.nome' => 'required|unique:servicos,nome,'.$this->servico['id'].',id,despachante_id,'.Auth::user()->despachante->id.'|max:191',
            'servico.preco' => 'required',
        ], [
            'servico.nome.required' => 'Obrigatório.',
            'servico.nome.unique' => 'Já existe um serviço com esse nome.',
            'servico.nome.max' => 'Máximo de 191 caracteres.',
            'servico.preco.required' => 'Obigatório.',
        ]);

        try {
            if ($this->servico['id'] == -1) {
                Auth::user()->despachante->servicos()->create([
                    'nome' => $this->servico['nome'],
                    'preco' => $this->regexMoney($this->servico['preco']),
                    'descricao' => $this->servico['descricao'] ?? '',
                ]);
                session()->flash('success', 'Serviço criado com sucesso!');
                $this->redirectRoute('despachante.servicos');
            } else {
                $this->servicos->find($this->servico['id'])->update([
                    'nome' => $this->servico['nome'],
                    'preco' => $this->regexMoney($this->servico['preco']),
                    'descricao' => $this->servico['descricao'],
                ]);
                $this->emit('success', ['message' => 'Serviço atualizado com sucesso!']);
            }
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao criar serviço.');
        }

    }

    public function delete()
    {
        try {
            $this->servicos->find($this->servico['id'])->delete();
            session()->flash('success', 'Serviço deletado com sucesso!');
            $this->redirectRoute('despachante.servicos');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao deletar serviço.');
        }
    }

    public function render()
    {
        return view('livewire.despachante.servico-editar');
    }
}
