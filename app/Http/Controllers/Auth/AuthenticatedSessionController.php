<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Caja;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $usuario = Auth::user();

        // Redirección según rol
        switch ($usuario->rol_id) {
            case 1:
                return redirect()->intended('/admin');
            case 2:
                return redirect()->intended('/contador');
            case 3:
                return redirect()->intended('/ayudante');
            default:
                return redirect()->intended('/dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function adminDashboard()
    {
        $estudiantes = Estudiante::count();
        $ingresosMes = Ingreso::where('fecha_pago', 'like', date('Y-m') . '%')->sum('monto');
        $egresosMes = Egreso::where('fecha_egreso', 'like', date('Y-m') . '%')->sum('monto');
        $cajas = Caja::all();

        return view('dashboard.admin', compact('estudiantes', 'ingresosMes', 'egresosMes', 'cajas'));
    }

}
