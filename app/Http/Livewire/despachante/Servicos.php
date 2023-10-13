<?php

namespace App\Http\Livewire\despachante;

use App\Traits\FunctionsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Servicos extends Component
{
    use FunctionsTrait;

    public $servicos;
    public $servico = [
        'id' => -1,
    ];

    public function mount()
    {
        $this->servicos = Auth::user()->despachante->servicos()->orderBy('nome')->get();
    }

    public function switchServico()
    {
        if ($this->servico['id'] == -1)
            $this->clearFields();
        else {
            $this->servico['nome'] = $this->servicos->find($this->servico['id'])->nome;
            $this->servico['preco'] = $this->regexMoneyToView($this->servicos->find($this->servico['id'])->preco);
            $this->servico['descricao'] = $this->servicos->find($this->servico['id'])->descricao;
        }
    }


    public function createOrUpdate()
    {
        $this->validate([
            'servico.nome' => 'required|unique:servicos,nome,' . $this->servico['id'] . ',id,despachante_id,' . Auth::user()->despachante->id . '|max:191',
            'servico.preco' => 'required',
        ], [
            'servico.nome.required' => 'Obrigatório.',
            'servico.nome.unique' => 'Já existe um serviço com esse nome.',
            'servico.nome.max' => 'Máximo de 191 caracteres.',
            'servico.preco.required' => 'Obigatório.',
        ]);

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

    public function delete()
    {
        $this->servicos->find($this->servico['id'])->delete();
        session()->flash('success', 'Serviço deletado com sucesso!');
        $this->redirectRoute('despachante.servicos');
    }

    public function render()
    {
        return view('livewire.despachante.servicos');
    }
}
