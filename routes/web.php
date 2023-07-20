<?php

use App\Http\Livewire\AtpvShow;
use App\Http\Livewire\despachante\Atpvs;
use App\Http\Livewire\despachante\ClienteEditar;
use App\Http\Livewire\despachante\Clientes;
use App\Http\Livewire\despachante\Dashboard;
use App\Http\Livewire\despachante\Processos;
use App\Http\Livewire\despachante\ProcessoShow;
use App\Http\Livewire\despachante\RelatorioPedidos;
use App\Http\Livewire\despachante\Servicos;
use App\Http\Livewire\despachante\UsuarioEditar;
use App\Http\Livewire\despachante\Usuarios;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::middleware(['despachante'])->prefix('despachante')->name('despachante.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/processos', Processos::class)->name('processos');
        Route::get('/processos/{id}', ProcessoShow::class)->name('processos.show');
        Route::get('/atpvs', Atpvs::class)->name('atpvs');
        Route::get('/atpvs/{id}', AtpvShow::class)->name('atpvs.show');
        Route::get('/clientes', Clientes::class)->name('clientes');
        Route::get('/clientes/{id}', ClienteEditar::class)->name('clientes.editar');
        Route::get('/usuarios', Usuarios::class)->name('usuarios');
        Route::get('/usuarios/{id}', UsuarioEditar::class)->name('usuarios.editar');
        Route::get('/servicos', Servicos::class)->name('servicos');
        Route::get('/relatorios/pedidos', RelatorioPedidos::class)->name('relatorios.pedidos');

    });
});
