<x-guest-layout>
    <div class="d-flex flex-column">
        <div class="row g-0 flex-fill">
            <div
                class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
                <div class="container container-tight my-5 px-lg-5">
                    <div class="text-center mb-4">
                        <a href="{{route('welcome')}}" class="navbar-brand navbar-brand-autodark">
                            <img src="{{asset('assets/img/logo3.png')}}" height="36" alt="SALED logo">
                            {{config('app.name')}}
                        </a>
                        <p>{{config('app.slogan')}}</p>
                    </div>
                    <h2 class="h3 text-center mb-3">
                        Faça login na sua conta
                        @error('name')
                        <p class="text-center text-red">Usuário ou Senha Incorretos</p>
                        @enderror
                    </h2>

                    <form id="login-form" action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nome de Usuário</label>
                            <input name="name" value="{{old('name')}}" class="form-control" required autofocus
                                   autocomplete="name" placeholder="Digite o nome de usuário">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                Password
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control"
                                       required autocomplete="current-password" placeholder="Digite a senha">
                            </div>
                            @if (Route::has('password.request'))
                                <span class="form-label-description">
                                  <a href="{{ route('password.request') }}">esqueci a senha</a>
                                </span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember">
                                <span class="form-check-label">Lembrar de mim neste dispositivo</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M15 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                                    <path d="M21 12h-13l3 -3"></path>
                                    <path d="M11 15l-3 -3"></path>
                                </svg>
                                Entrar
                            </button>
                        </div>
                    </form>
                    <h3>Usuarios Testes</h3>
                    <div class="d-flex justify-content-start gap-2">
                        <div>
                            <a id="a" class="btn btn-secondary">
                                Despachante
                            </a>
                        </div>
                        <div>
                            <a id="b" class="btn btn-secondary">
                                Cliente
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
                <div class="bg-cover h-100 min-vh-100"
                     style="background-image: url({{asset('assets/img/mecanico.jpeg')}})"></div>
            </div>
        </div>
    </div>
    <script>
        $('#a').click(function () {
            $('input[name="name"]').val('despachante');
            $('input[name="password"]').val('123');
            $('#login-form').submit();
        });
        $('#b').click(function () {
            $('input[name="name"]').val('cliente');
            $('input[name="password"]').val('123');
            $('#login-form').submit();
        });
    </script>
</x-guest-layout>
