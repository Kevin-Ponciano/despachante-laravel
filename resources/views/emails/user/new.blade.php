@component('mail::message')
# Bem-vindo(a)!

Olá,<br>
Seja bem-vindo ao sistema <b>{{ config('app.name') }}</b>.<br>

Sua conta foi criada pela empresa <b>{{ $user->despachante->nome() }}</b>.<br>
Abaixo estão suas credenciais de acesso:

Nome de Usuário: <b>{{ $user->name }}</b><br>
Senha: <b>{{ $password }}</b>

@component('mail::button', ['url' => route('login')])
    Acessar
@endcomponent
<br>
@endcomponent
