<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Perfil extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $email;
    public $oldPassword;
    public $newPassword;
    public $photo;

    public function mount()
    {
        $this->user = \Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    protected $rulesMsgPhoto = [[
        'photo' => 'image|max:10240',
    ], [
        'photo.image' => 'Formato inválido (Somente JPG).',
        'photo.max' => 'Tamanho máximo de 5MB.',
    ]];


    public function updatedPhoto()
    {
        $this->validate($this->rulesMsgPhoto[0], $this->rulesMsgPhoto[1]);
    }

    public function savePhoto()
    {
        if (!$this->photo)
            return;
        $this->user->update([
            'profile_photo_path' => $this->photo->store('profile-photos', 'public'),
        ]);

        $this->emit('savedPhoto');
    }

    public function deletePhoto()
    {
        \Storage::disk('public')->delete($this->user->profile_photo_path);
        $this->user->update([
            'profile_photo_path' => null,
        ]);

        $this->emit('deletedPhoto');
    }

    public function changeName()
    {
        $this->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9_ ]+$/|unique:users,name,' . $this->user->id
        ], [
            'name.required' => 'Obrigatório.',
            'name.regex' => 'O nome de usuário não pode conter caracteres especiais.',
            'name.unique' => 'Nome de usuário já cadastrado.',
        ]);

        $this->user->update([
            'name' => $this->name,
        ]);

        $this->emit('savedName');
    }

    public function changeEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,' . $this->user->id
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

        $this->user->update([
            'password' => \Hash::make($this->newPassword),
        ]);

        $this->emit('savedPassword');
    }


    public function render()
    {
        return view('livewire.perfil');
    }
}
