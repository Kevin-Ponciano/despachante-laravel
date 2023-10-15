<?php

namespace App\Http\Livewire\despachante;

use App\Mail\NewClient;
use App\Traits\FunctionsTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Mail;

class ClienteNovo extends Component
{
    use FunctionsTrait;

    public $nome;
    public $email;
    public $preco;
    public $qtd_clientes;

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

    public function mount()
    {
        $qtd_clientesTotal = Auth::user()->despachante->plano->qtd_clientes;
        $qtd_clientesCadastrados = Auth::user()->despachante->clientes()->count();
        $this->qtd_clientes = $qtd_clientesTotal - $qtd_clientesCadastrados;
    }

    public function store()
    {
        if ($this->qtd_clientes <= 0) {
            $this->emit('error', "<b class='text-uppercase'>Limite de clientes atingido</b><br> Entre em contato com o suporte<br> para aumentar o limite de clientes");
            return;
        }
        $this->validate();

        $nomeUsuario = Str::lower(Str::replace(' ', '_', $this->nome));
        $year = date('Y');
        $password = "$nomeUsuario@$year";

        $preco = [
            'placa1' => $this->regexMoney($this->preco['placa1'] ?? 0),
            'placa2' => $this->regexMoney($this->preco['placa2'] ?? 0),
            'loja' => $this->regexMoney($this->preco['loja'] ?? 0),
            'terceiro' => $this->regexMoney($this->preco['terceiro'] ?? 0),
            'atpv' => $this->regexMoney($this->preco['atpv'] ?? 0),
            'renaveEntrada' => $this->regexMoney($this->preco['renaveEntrada'] ?? 0),
            'renaveSaida' => $this->regexMoney($this->preco['renaveSaida'] ?? 0),
        ];

        $cliente = Auth::user()->despachante->clientes()->create([
            'nome' => $this->nome,
            'status' => 'at',
            'preco_1_placa' => $preco['placa1'],
            'preco_2_placa' => $preco['placa2'],
            'preco_atpv' => $preco['loja'],
            'preco_loja' => $preco['terceiro'],
            'preco_terceiro' => $preco['atpv'],
            'preco_renave_entrada' => $preco['renaveEntrada'],
            'preco_renave_saida' => $preco['renaveSaida'],
        ]);

        $user = $cliente->users()->create([
            'name' => $nomeUsuario,
            'email' => $this->email,
            'password' => Hash::make($password),
            'role' => 'ca', // cliente-admin
            'status' => 'at',
        ]);

        
        Mail::to($this->email)->send(new NewClient($user, $password));
        $this->emit('tableRefresh');
        $this->emit('success', ['message' => 'Cliente cadastrado com sucesso']);
        $this->clearFields();
    }

    public function clearFields()
    {
        $this->nome = null;
        $this->email = null;
        $this->preco = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.despachante.cliente-novo');
    }
}
