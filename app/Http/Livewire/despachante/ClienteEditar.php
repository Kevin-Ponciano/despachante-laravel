<?php

namespace App\Http\Livewire\despachante;

use App\Traits\FunctionsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClienteEditar extends Component
{
    use FunctionsTrait;

    public $cliente;
    public $nomeCliente;
    public $usuario;
    public $nomeUsuario;
    public $emailUsuario;
    public $preco;
    public $status;

    public function mount($id)
    {
        $this->cliente = Auth::user()->despachante->clientes()->where('numero_cliente', $id)->firstOrFail();
        $this->usuario = $this->cliente->users()->where('role', 'ca')->firstOrFail();
        $this->nomeCliente = $this->cliente->nome;
        $this->nomeUsuario = $this->usuario->name;
        $this->emailUsuario = $this->usuario->email;
        $this->preco = [
            'placa1' => $this->regexMoneyToView($this->cliente->preco_1_placa),
            'placa2' => $this->regexMoneyToView($this->cliente->preco_2_placa),
            'loja' => $this->regexMoneyToView($this->cliente->preco_loja),
            'terceiro' => $this->regexMoneyToView($this->cliente->preco_terceiro),
            'atpv' => $this->regexMoneyToView($this->cliente->preco_atpv),
        ];
        $this->status = $this->cliente->status;
    }


    public function updateNomeCliente()
    {
        $this->validate([
            'nomeCliente' => 'required|unique:clientes,nome',
        ], [
            'nomeCliente.required' => 'Obrigatório.',
            'nomeCliente.unique' => 'Cliente já cadastrado.',
        ]);

        $this->cliente->update([
            'nome' => $this->nomeCliente,
        ]);

        $this->emit('savedName');
    }

    public function updatePreco()
    {
        $preco = [
            'placa1' => $this->regexMoney($this->preco['placa1'] ?? 0),
            'placa2' => $this->regexMoney($this->preco['placa2'] ?? 0),
            'loja' => $this->regexMoney($this->preco['loja'] ?? 0),
            'terceiro' => $this->regexMoney($this->preco['terceiro'] ?? 0),
            'atpv' => $this->regexMoney($this->preco['atpv'] ?? 0),
        ];

        $this->cliente->update([
            'preco_1_placa' => $preco['placa1'],
            'preco_2_placa' => $preco['placa2'],
            'preco_atpv' => $preco['loja'],
            'preco_loja' => $preco['terceiro'],
            'preco_terceiro' => $preco['atpv'],
        ]);

        $this->emit('savedPreco');
    }

    public function updateUsuarioCliente()
    {
        $this->validate([
            'nomeUsuario' => 'required|regex:/^[a-zA-Z0-9_]+$/|unique:users,name',
        ], [
            'nomeUsuario.required' => 'Obrigatório.',
            'nomeUsuario.regex' => 'O nome de usuário deve conter apenas letras, números e sublinhados.',
            'nomeUsuario.unique' => 'Nome de usuário já cadastrado.',
        ]);

        $this->usuario->update([
            'name' => $this->nomeUsuario,
        ]);

        $this->emit('savedUserClienteName');
    }

    public function switchStatus()
    {
        $this->cliente->update([
            'status' => $this->cliente->status == 'at' ? 'in' : 'at',
        ]);

        if ($this->cliente->status == 'at') {
            $this->emit('success', ['message' => 'Cliente ativado com sucesso']);
            $this->status = 'at';
        } else {
            session()->flash('error', "Cliente inativado com sucesso");
            redirect()->route('despachante.clientes');
        }

    }

    public function redefinirSenha($id)
    {
        # TODO Enviar um email para o usuario poder redefinir a senha
    }

    public function delete()
    {
        $this->cliente->delete();

        session()->flash('success', "Cliente deletado com sucesso");
        return redirect()->route('despachante.clientes');
    }

    public function render()
    {
        return view('livewire.despachante.cliente-editar')
            ->layout('layouts.despachante');
    }
}
