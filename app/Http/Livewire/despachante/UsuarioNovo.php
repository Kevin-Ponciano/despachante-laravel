<?php

namespace App\Http\Livewire\despachante;

use App\Traits\FunctionsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UsuarioNovo extends Component
{
    use FunctionsTrait;

    public $name;
    public $email;
    public $role = 'du';
    public $password;
    public $qtd_usuarios;

    protected $rules = [
        'name' => 'required|regex:/^[a-zA-Z0-9_]+$/|unique:users,name',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'name.required' => 'Obrigatório.',
        'name.regex' => 'O nome de usuário deve conter apenas letras, números e sublinhados.',
        'name.unique' => 'Nome de usuário já cadastrado.',
        'email.required' => 'Obrigatório.',
        'email.email' => 'E-mail inválido.',
        'email.unique' => 'E-mail já cadastrado.',
        'password.required' => 'Obrigatório.',
        'password.min' => 'Mínimo de 6 caracteres.',
    ];

    public function mount()
    {
        $qtd_usuariosTotal = Auth::user()->despachante->plano->qtd_usuarios;
        $qtd_usuariosCadastrados = Auth::user()->despachante->users()->count();
        $this->qtd_usuarios = $qtd_usuariosTotal - $qtd_usuariosCadastrados;
    }

    public function store()
    {
        if ($this->qtd_usuarios <= 0) {
            $this->emit('error', "<b class='text-uppercase'>Limite de usuários atingido</b><br> Entre em contato com o suporte<br> para aumentar o limite de usuários");
            return;
        }
        $this->validate();

        $this->password = bcrypt($this->password);

        Auth::user()->despachante->users()->create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => 'at',
            'password' => $this->password,
        ]);

        $this->emit('tableRefresh');
        $this->emit('success', ['message' => 'Usuário cadastrado com sucesso']);
        $this->clearFields();
    }

    public function clearFields()
    {
        $this->name = '';
        $this->email = '';
        $this->role = 'du';
        $this->password = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.despachante.usuario-novo')
            ->layout('layouts.despachante');
    }
}
