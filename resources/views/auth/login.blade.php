<x-guest-layout>
    <div class="d-flex flex-column">
        <div class="row g-0 flex-fill">
            <div
                class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
                <div class="container container-tight my-5 px-lg-5">
                    <div class="text-center mb-4">
                        <a class="navbar-brand navbar-brand-autodark"><img src="{{asset('assets/img/logo3.png')}}"
                                                                           height="36" alt="SALED logo">
                            ALED
                        </a>
                        <p>Sistema Despachante</p>
                    </div>
                    <h2 class="h3 text-center mb-3">
                        Faça login na sua conta
                        @error('name')
                        <p class="text-center text-red">Usuário ou Senha Incorretos</p>
                        @enderror
                    </h2>

                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nome de Usuário</label>
                            <input name="name" value="{{old('name')}}" class="form-control" required autofocus
                                   autocomplete="name"/>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                Password
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control"
                                       required autocomplete="current-password">
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
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
                <!-- Photo -->
                <div class="bg-cover h-100 min-vh-100"
                     style="background-image: url({{asset('assets/img/mecanico.jpeg')}})"></div>
            </div>
        </div>
    </div>
</x-guest-layout>
