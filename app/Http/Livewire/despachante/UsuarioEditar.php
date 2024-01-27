<?php

namespace App\Http\Livewire\despachante;

use App\Jobs\sendPasswordResetNotificationJob;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Spatie\Permission\Models\Role;
use Str;
use Throwable;

class UsuarioEditar extends Component
{
    public $user;

    public $name;

    public $email;

    public $role;

    public $status;

    public $userPermissions;

    public $permissions;

    public function mount($id)
    {
        $this->user = Auth::user()->despachante->users()->with('permissions')->findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
        $this->status = $this->user->status;

        $roleName = '[DESPACHANTE] - ADMIN';
        $excludedPermission = '[DESPACHANTE] - Acessar Sistema';
        try {
            $role = Role::with(['permissions' => function ($query) use ($excludedPermission) {
                $query->where('name', '!=', $excludedPermission)->orderBy('name');
            }])->where('name', $roleName)->firstOrFail();
            $this->permissions = collect($role->permissions)->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'alias' => Str::after($permission->name, '[DESPACHANTE] - '),
                ];
            })->all();
            $userPermissions = $this->user->permissions->pluck('name')->all();
            $this->userPermissions = collect($this->permissions)->mapWithKeys(function ($permission) use ($userPermissions) {
                return [$permission['name'] => in_array($permission['name'], $userPermissions)];
            })->all();
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao carregar permissões');
        }
    }

    public function changeName()
    {
        $this->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9_ ]+$/|unique:users,name,'.$this->id,
        ], [
            'name.required' => 'Obrigatório.',
            'name.unique' => 'Nome de usuário já cadastrado.',
            'name.regex' => 'O nome de usuário não pode conter caracteres especiais.',
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
            'email' => 'required|email|unique:users,email,'.$this->id,
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

    public function changePermission()
    {
        try {
            $permissions = array_keys(array_filter($this->userPermissions, function ($hasPermission, $permissionName) {
                return $hasPermission && in_array($permissionName, array_column($this->permissions, 'name'));
            }, ARRAY_FILTER_USE_BOTH));

            $this->user->syncPermissions($permissions);

            $this->emit('savedPermission');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao atualizar permissões do usuário');
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
            $this->user->update(['status' => 'ex']);
            session()->flash('success', 'Usuário deletado com sucesso');

            return redirect()->route('despachante.usuarios');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao deletar usuário');
        }
    }

    public function resetPassword()
    {
        try {
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
