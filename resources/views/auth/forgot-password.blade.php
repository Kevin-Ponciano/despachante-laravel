<x-guest-layout>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a class="navbar-brand navbar-brand-autodark">
                    <img src="{{asset('assets/img/logo3.png')}}" height="36" alt="saled logo">
                    ALED
                </a>
            </div>
            <form class="card card-md" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Esqueceu sua senha</h2>
                    <p class="text-muted mb-4">Digite seu endereço de e-mail e um link de redefinição de senha será
                        enviado para você!</p>
                    <div class="mb-3">
                        <label class="form-label">Endereço de email</label>
                        <input type="email" name="email" class="form-control" placeholder="Digite o e-mail"
                               :value="old('email')" required autofocus autocomplete="username">
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                <path d="M3 7l9 6l9 -6"></path>
                            </svg>
                            Me envie um link de redefinição de senha
                        </button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted mt-3">
                Esqueça, <a href="{{route('login')}}">Me envie de volta</a> para a tela de login.
            </div>
        </div>
    </div>
</x-guest-layout>

