<?php

use App\Http\Controllers\DashboardRouteController;
use App\Http\Controllers\Fortify\PasswordResetLinkController;
use App\Http\Controllers\SearchPedidoController;
use App\Http\Livewire\Atpvs;
use App\Http\Livewire\AtpvShow;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\despachante\ClienteEditar;
use App\Http\Livewire\despachante\Clientes;
use App\Http\Livewire\despachante\RelatorioPedidos;
use App\Http\Livewire\despachante\Servicos;
use App\Http\Livewire\despachante\Settings;
use App\Http\Livewire\despachante\UsuarioEditar;
use App\Http\Livewire\despachante\Usuarios;
use App\Http\Livewire\Perfil;
use App\Http\Livewire\Processos;
use App\Http\Livewire\ProcessoShow;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('lading-page');
})->name('welcome');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'status'])->group(function () {

    Route::get('/dashboard', [DashboardRouteController::class, 'index'])->name('dashboard');
    Route::get('/pedido/{id}', [SearchPedidoController::class, 'index'])->name('get-pedido');

    Route::middleware(['can:[DESPACHANTE] - Acessar Sistema'])->prefix('despachante')->name('despachante.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/processos', Processos::class)->name('processos');
        Route::get('/processos/{id}', ProcessoShow::class)->name('processos.show');
        Route::get('/transferencias', Atpvs::class)->name('atpvs');
        Route::get('/transferencias/{id}', AtpvShow::class)->name('atpvs.show');

        Route::middleware(['can:[DESPACHANTE] - Alterar Configurações'])->group(function () {
            Route::get('/settings', Settings::class)->name('settings');
        });

        Route::middleware(['can:[DESPACHANTE] - Gerenciar Clientes'])->group(function () {
            Route::get('/clientes', Clientes::class)->name('clientes');
            Route::get('/clientes/table', [Clientes::class, 'dataTable'])->name('clientes.table');
            Route::get('/clientes/{id}', ClienteEditar::class)->name('clientes.editar');
        });

        Route::middleware(['can:[DESPACHANTE] - Gerenciar Usuários'])->group(function () {
            Route::get('/usuarios', Usuarios::class)->name('usuarios');
            Route::get('/usuarios/table', [Usuarios::class, 'dataTable'])->name('usuarios.table');
            Route::get('/usuarios/{id}', UsuarioEditar::class)->name('usuarios.editar');
        });

        Route::middleware('can:[DESPACHANTE] - Gerenciar Serviços')->group(function () {
            Route::get('/servicos', Servicos::class)->name('servicos');
        });

        Route::get('/relatorios/pedidos', RelatorioPedidos::class)->name('relatorios.pedidos');
        Route::get('/perfil', Perfil::class)->name('perfil');

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
