<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Caja;

class ContadorDashboardController extends Controller
{
    public function index()
    {
        $ingresosMes = Ingreso::where('fecha_pago', 'like', date('Y-m') . '%')->sum('monto');
        $egresosMes = Egreso::where('fecha_egreso', 'like', date('Y-m') . '%')->sum('monto');
        $cajas = Caja::all();

        return view('dashboard.contador', compact('ingresosMes', 'egresosMes', 'cajas'));
    }
}
