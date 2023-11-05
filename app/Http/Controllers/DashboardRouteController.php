<?php

namespace App\Http\Controllers;

class DashboardRouteController extends Controller
{
    public function index()
    {
        if (auth()->user()->isDespachante()) {
            return redirect()->route('despachante.dashboard');
        } elseif (auth()->user()->isCliente()) {
            return redirect()->route('cliente.dashboard');
        } else {
            \Log::info('Usuário sem associação');
        }
        abort(403, 'Usuário sem associação');
    }
}
