<x-guest-layout>
    <div class="page page-center border-top-wide border-primary">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a class="navbar-brand navbar-brand-autodark">
                    <img src="{{asset('assets/img/logo3.png')}}" height="36" alt="saled logo">
                    {{config('app.name')}}
                </a>
            </div>
            <form class="card card-md" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Redefinir senha</h2>
                    <div class="mb-3">
                        <label class="form-label">Endereço de email</label>
                        <input id="email" class="form-control" type="email" name="email"
                               value="{{old('email', $request->email)}}" required autofocus autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha</label>
                        <input id="password" class="form-control" type="password" name="password" required
                               autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirme a Nova Senha</label>
                        <input id="password_confirmation" class="form-control" type="password"
                               name="password_confirmation" required autocomplete="new-password">
                        @error('password')
                        @if($message === 'validation.confirmed')
                            <span class="text-red">As senhas não conferem</span>
                        @else
                            <span class="text-red">A senha deve ter no mínimo 8 caracteres</span>
                        @endif
                        @enderror
                        @if ($errors->any())
                            <div class="text-danger mt-1">
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <span>{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24"
                                 height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path>
                                <path d="M15 9h.01"></path>
                            </svg>
                            Redefinir senha
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
