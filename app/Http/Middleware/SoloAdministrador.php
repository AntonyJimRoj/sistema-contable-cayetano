<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloAdministrador
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol_id === 1) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }
}
