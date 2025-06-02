<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;
use Illuminate\Support\Facades\Auth;

class AyudanteDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $hoy = date('Y-m-d');

        $ingresosHoy = Ingreso::where('usuario_id', $userId)
            ->whereDate('fecha_pago', $hoy)
            ->count();

        $egresosHoy = Egreso::where('usuario_id', $userId)
            ->whereDate('fecha_egreso', $hoy)
            ->count();

        return view('dashboard.ayudante', compact('ingresosHoy', 'egresosHoy', 'hoy'));
    }
}
