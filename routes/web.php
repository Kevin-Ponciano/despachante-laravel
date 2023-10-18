<?php

use App\Http\Livewire\Atpvs;
use App\Http\Livewire\AtpvShow;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\despachante\ClienteEditar;
use App\Http\Livewire\despachante\Clientes;
use App\Http\Livewire\despachante\RelatorioPedidos;
use App\Http\Livewire\despachante\Servicos;
use App\Http\Livewire\despachante\UsuarioEditar;
use App\Http\Livewire\despachante\Usuarios;
use App\Http\Livewire\Perfil;
use App\Http\Livewire\Processos;
use App\Http\Livewire\ProcessoShow;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

Route::get('/', function () {
    return view('lading-page');
})->name('welcome');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'status'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->isDespachante())
            return redirect()->route('despachante.dashboard');
        elseif (auth()->user()->isCliente())
            return redirect()->route('cliente.dashboard');
        else
            abort(500);
    })->name('dashboard');

    Route::get('/pedido/{id}', function ($id) {
        $pedido = Auth::user()->empresa()->pedidos()->with('processo', 'atpv')->where('numero_pedido', $id)->firstOrFail();
        $route = null;
        if ($pedido->processo) {
            $route = Auth::user()->isDespachante() ? 'despachante.processos.show' : (Auth::user()->isCliente() ? 'cliente.processos.show' : null);
        } elseif ($pedido->atpv) {
            $route = Auth::user()->isDespachante() ? 'despachante.atpvs.show' : (Auth::user()->isCliente() ? 'cliente.atpvs.show' : null);
        }
        if ($route) {
            return redirect()->route($route, $pedido->numero_pedido);
        } else {
            abort(500);
        }
    })->name('get-pedido');


    Route::middleware(['can:[DESPACHANTE] - Acessar Sistema'])->prefix('despachante')->name('despachante.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/processos', Processos::class)->name('processos');
        Route::get('/processos/{id}', ProcessoShow::class)->name('processos.show');
        Route::get('/transferencias', Atpvs::class)->name('atpvs');
        Route::get('/transferencias/{id}', AtpvShow::class)->name('atpvs.show');
        Route::get('/clientes', Clientes::class)->name('clientes');
        Route::get('/clientes/table', [Clientes::class, 'dataTable'])->name('clientes.table');
        Route::get('/clientes/{id}', ClienteEditar::class)->name('clientes.editar');
        Route::get('/usuarios', Usuarios::class)->name('usuarios');
        Route::get('/usuarios/table', [Usuarios::class, 'dataTable'])->name('usuarios.table');
        Route::get('/usuarios/{id}', UsuarioEditar::class)->name('usuarios.editar');
        Route::get('/servicos', Servicos::class)->name('servicos');
        Route::get('/relatorios/pedidos', RelatorioPedidos::class)->name('relatorios.pedidos');
        Route::get('/perfil', Perfil::class)->name('perfil');
        Route::get('/send-email', function () {
            $user = Auth::user();
            Mail::to('kevin.ponciano@outlook.com')->send(new \App\Mail\NewUser($user->name, '123456'));
//            return view('emails.user.new', compact('user'));
        });
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('reset-password');
    });

    Route::middleware(['can:[CLIENTE] - Acessar Sistema'])->prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/processos', Processos::class)->name('processos');
        Route::get('/processos/{id}', ProcessoShow::class)->name('processos.show');
        Route::get('/transferencias', Atpvs::class)->name('atpvs');
        Route::get('/transferencias/{id}', AtpvShow::class)->name('atpvs.show');
        Route::get('/perfil', Perfil::class)->name('perfil');
    });
});
