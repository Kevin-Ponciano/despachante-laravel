<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if (Auth::user()->isDespachante()) {
            return $request->wantsJson()
                ? response()->json(['two_factor' => false])
                : redirect()->intended(route('despachante.dashboard'));
        }
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(route('cliente.dashboard'));
    }
}
