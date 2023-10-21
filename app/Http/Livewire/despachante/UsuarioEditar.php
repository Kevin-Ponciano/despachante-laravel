<?php

namespace App\Http\Livewire\despachante;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UsuarioEditar extends Component
{
    public $user;
    public $name;
    public $email;
    public $role;
    public $status;

    public function mount($id)
    {
        $this->user = Auth::user()->despachante->users()->findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
        $this->status = $this->user->status;

    }

    public function changeName()
    {
        $this->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9_ ]+$/|unique:users,name,' . $this->id,
        ], [
            'name.required' => 'Obrigatório.',
            'name.unique' => 'Nome de usuário já cadastrado.',
            'name.regex' => 'O nome de usuário não pode conter caracteres especiais.'
        ]);
        $this->user->update([
            'name' => $this->name,
        ]);
        $this->emit('savedName');
    }

    public function changeEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,' . $this->id,
        ], [
            'email.required' => 'Obrigatório.',
            'email.email' => 'E-mail inválido.',
            'email.unique' => 'E-mail já cadastrado.',
        ]);
        $this->user->update([
            'email' => $this->email,
        ]);
        $this->emit('savedEmail');
    }

    public function changeRole()
    {
        #TODO: Implementar permissoes parecidos com o do BACKPACK
        $usersAdmin = Auth::user()->despachante->users()->where('role', 'da')->get();
        if ($usersAdmin->count() == 1 && $this->role != 'da') {
            $this->addError('role', 'Deve haver pelo menos um administrador.');
            return;
        }
        $this->user->update([
            'role' => $this->role,
        ]);
        $this->emit('savedRole');
    }

    public function switchStatus()
    {
        $this->user->update([
            'status' => $this->user->status == 'at' ? 'in' : 'at',
        ]);

        if ($this->user->status == 'at') {
            $this->emit('success', ['message' => 'Usuário ativado com sucesso']);
            $this->status = 'at';
        } else {
            $this->emit('error', 'Usuário desativado com sucesso');
            $this->status = 'in';
        }

    }

    public function delete()
    {
        $this->user->delete();

        session()->flash('success', "Usuário deletado com sucesso");
        return redirect()->route('despachante.usuarios');
    }

    public function resetPassword()
    {
        $this->emit('success', ['message' => 'Um e-mail será enviado para o usuário<br> para que ele possa redefinir sua senha']);
    }

    public function render()
    {
        return view('livewire.despachante.usuario-editar');
    }
}
