<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Caja;

class AdminDashboardController extends Controller
{
    public function adminDashboard()
    {
        $estudiantes = Estudiante::count();

        $ingresosMes = Ingreso::where('fecha_pago', 'like', date('Y-m') . '%')->sum('monto');
        $egresosMes = Egreso::where('fecha_egreso', 'like', date('Y-m') . '%')->sum('monto');

        $cajas = Caja::all();

        return view('dashboard.admin', compact('estudiantes', 'ingresosMes', 'egresosMes', 'cajas'));
    }
}
