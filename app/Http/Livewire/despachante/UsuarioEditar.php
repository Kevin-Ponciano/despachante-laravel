<?php

namespace App\Http\Livewire\despachante;

use App\Jobs\sendPasswordResetNotificationJob;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Throwable;

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
        try {
            $this->user->update([
                'name' => $this->name,
            ]);
            $this->emit('savedName');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao atualizar nome de usuário');
        }
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
        try {
            $this->user->update([
                'email' => $this->email,
            ]);
            $this->emit('savedEmail');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao atualizar e-mail de usuário');
        }
    }

    public function changeRole()
    {
        #TODO: Implementar permissoes parecidos com o do BACKPACK
        try {
            $usersAdmin = Auth::user()->despachante->users()->where('role', 'da')->get();
            if ($usersAdmin->count() == 1 && $this->role != 'da') {
                $this->addError('role', 'Deve haver pelo menos um administrador.');
                return;
            }
            $this->user->update([
                'role' => $this->role,
            ]);
            $this->emit('savedRole');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao atualizar permissões de usuário');
        }
    }

    public function switchStatus()
    {
        try {
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
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao atualizar status de usuário');
        }
    }

    public function delete()
    {
        try {
            $this->user->delete();
            session()->flash('success', "Usuário deletado com sucesso");
            return redirect()->route('despachante.usuarios');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao deletar usuário');
        }
    }

    public function resetPassword()
    {
        try {
            //TODO: corrigir, https://laracasts.com/series/laravel-authentication-options
            sendPasswordResetNotificationJob::dispatch($this->user);
            $this->emit('success', ['message' => 'Um e-mail será enviado para o usuário<br> para que ele possa redefinir sua senha']);
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao redefinir senha de usuário');
        }
    }

    public function render()
    {
        return view('livewire.despachante.usuario-editar');
    }
}
