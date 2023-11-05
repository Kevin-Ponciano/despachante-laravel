<?php

namespace App\Http\Livewire;

use Auth;
use Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Log;
use Storage;
use Throwable;

class Perfil extends Component
{
    use WithFileUploads;

    public $user;

    public $name;

    public $email;

    public $oldPassword;

    public $newPassword;

    public $photo;

    protected $rulesMsgPhoto = [[
        'photo' => 'image|max:10240',
    ], [
        'photo.image' => 'Formato inválido (Somente JPG).',
        'photo.max' => 'Tamanho máximo de 5MB.',
    ]];

    protected $listeners = ['$refresh'];

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function updatedPhoto()
    {
        $this->validate($this->rulesMsgPhoto[0], $this->rulesMsgPhoto[1]);
    }

    public function savePhoto()
    {
        try {
            if (! $this->photo) {
                return;
            }
            $this->delete();
            $this->user->update([
                'profile_photo_path' => $this->photo->store('profile-photos', 'public'),
            ]);
            $this->emit('$refresh');
            $this->emit('savedPhoto');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao salvar foto.');
        }
    }

    public function delete()
    {
        $path = $this->user->profile_photo_path;
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function deletePhoto()
    {
        try {

            $this->delete();
            $this->user->update([
                'profile_photo_path' => null,
            ]);
            $this->emit('$refresh');
            $this->emit('deletedPhoto');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao deletar foto.');
        }
    }

    public function changeName()
    {
        $this->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9_ ]+$/|unique:users,name,'.$this->user->id,
        ], [
            'name.required' => 'Obrigatório.',
            'name.regex' => 'O nome de usuário não pode conter caracteres especiais.',
            'name.unique' => 'Nome de usuário já cadastrado.',
        ]);

        try {
            $this->user->update([
                'name' => $this->name,
            ]);

            $this->emit('savedName');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao salvar nome.');
        }
    }

    public function changeEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,'.$this->user->id,
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
            $this->emit('error', 'Erro ao salvar e-mail.');
        }
    }

    public function changePassword()
    {
        $this->validate(
            [
                'oldPassword' => 'current_password',
                'newPassword' => 'required|min:8',
            ],
            [
                'oldPassword.current_password' => 'Senha atual incorreta.',
                'newPassword.required' => 'Obrigatório.',
                'newPassword.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
            ]
        );

        try {
            $this->user->update([
                'password' => Hash::make($this->newPassword),
            ]);

            $this->emit('savedPassword');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao salvar senha.');
        }
    }

    public function render()
    {
        return view('livewire.perfil');
    }
}
