<?php

namespace App\Http\Livewire\despachante;

use App\Traits\FunctionsTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class ClienteNovo extends Component
{
    use FunctionsTrait;

    public $nome;
    public $email;
    public $preco;

    protected $rules = [
        'nome' => 'required|unique:clientes,nome',
        'email' => 'required|email|unique:users,email',
    ];

    protected $messages = [
        'nome.required' => 'Obrigatório.',
        'nome.unique' => 'Cliente já cadastrado.',
        'email.required' => 'Obrigatório.',
        'email.email' => 'E-mail inválido.',
        'email.unique' => 'E-mail já cadastrado.',
    ];

    public function store()
    {
        $this->validate();

        $nomeUsuario = Str::lower(Str::replace(' ', '_', $this->nome));
        $year = date('Y');
        $password = Hash::make("$nomeUsuario@$year");

        $preco = [
            'placa1' => $this->regexMoney($this->preco['placa1'] ?? 0),
            'placa2' => $this->regexMoney($this->preco['placa2'] ?? 0),
            'loja' => $this->regexMoney($this->preco['loja'] ?? 0),
            'terceiro' => $this->regexMoney($this->preco['terceiro'] ?? 0),
            'atpv' => $this->regexMoney($this->preco['atpv'] ?? 0),
        ];

        $cliente = Auth::user()->despachante->clientes()->create([
            'nome' => $this->nome,
            'status' => 'at',
            'preco_1_placa' => $preco['placa1'],
            'preco_2_placa' => $preco['placa2'],
            'preco_atpv' => $preco['loja'],
            'preco_loja' => $preco['terceiro'],
            'preco_terceiro' => $preco['atpv'],
        ]);

        $cliente->users()->create([
            'name' => $nomeUsuario,
            'email' => $this->email,
            'password' => $password,
            'role' => 'ca' // cliente-admin
        ]);

        # TODO: send email to user
        $this->emit('tableClientesRefresh');
        $this->emit('success', ['message' => 'Cliente cadastrado com sucesso']);
        $this->clearFields();
    }

    public function clearFields()
    {
        $this->nome = null;
        $this->email = null;
        $this->preco = null;
    }

    public function render()
    {
        return view('livewire.despachante.cliente-novo')
            ->layout('layouts.despachante');
    }
}
