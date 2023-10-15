<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StatusVerifyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->isDespachante()) {
            if (\Auth::user()->despachante->status == 'in') {
                abort(423, 'Acesso Negado', ['message' => 'Seu acesso foi bloqueado. Entre em contato com o administrador.']);
            } elseif (\Auth::user()->status == 'in') {
                abort(423, 'Acesso Negado', ['message' => 'Seu usuário foi bloqueado. Entre em contato com o administrador da sua Empresa Despachante.']);
            }
        } elseif (\Auth::user()->isCliente()) {
            if (\Auth::user()->cliente->status == 'in') {
                abort(423, 'Acesso Negado', ['message' => 'Seu Despachante bloqueou seu acesso. Entre em contato com ele ou se for um erro entre em contato com o Suporte.']);
            } elseif (\Auth::user()->status == 'in') {
                abort(423, 'Acesso Negado', ['message' => 'Seu usuário foi bloqueado. Entre em contato com o administrador.']);
            }
        }
        return $next($request);
    }
}
