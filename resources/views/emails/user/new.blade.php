@component('mail::message')
# Novo Usuário Criado

Olá, Seja bem-vindo ao sistema <b>{{ config('app.name') }}</b>.<br>

Sua conta foi criada com sucesso.<br>
Abaixo estão suas credenciais de acesso:

Nome de Usuário: <b>{{ $name }}</b><br>
Senha: <b>{{ $password }}</b>

@component('mail::button', ['url' => route('login')])
    Acessar
@endcomponent
<br>
@endcomponent
