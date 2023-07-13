<?php

use App\Http\Livewire\despachante\Atpvs;
use App\Http\Livewire\despachante\Clientes;
use App\Http\Livewire\despachante\Dashboard;
use App\Http\Livewire\despachante\Processos;
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
        Route::get('/atpvs', Atpvs::class)->name('atpvs');
        Route::get('/clientes', Clientes::class)->name('clientes');
    });
});
