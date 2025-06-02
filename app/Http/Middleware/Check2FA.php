<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Check2FA
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->google2fa_secret && !session('2fa_passed')) {
            return redirect()->route('2fa.validate');
        }

        return $next($request);
    }

}
