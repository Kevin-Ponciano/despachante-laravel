<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return JsonResponse|RedirectResponse|Response
     */
    public function toResponse($request): JsonResponse|RedirectResponse|Response
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
