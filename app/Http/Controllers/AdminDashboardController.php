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
        $estudiantes = $this->obtenerCantidadEstudiantes();
        $ingresosMes = $this->obtenerIngresosDelMes();
        $egresosMes = $this->obtenerEgresosDelMes();
        $cajas = $this->obtenerTodasLasCajas();

        return view('dashboard.admin', compact(
            'estudiantes',
            'ingresosMes',
            'egresosMes',
            'cajas'
        ));
    }

    private function obtenerCantidadEstudiantes()
    {
        return Estudiante::count();
    }

    private function obtenerIngresosDelMes()
    {
        $mesActual = date('Y-m');
        return Ingreso::where('fecha_pago', 'like', $mesActual . '%')->sum('monto');
    }

    private function obtenerEgresosDelMes()
    {
        $mesActual = date('Y-m');
        return Egreso::where('fecha_egreso', 'like', $mesActual . '%')->sum('monto');
    }

    private function obtenerTodasLasCajas()
    {
        return Caja::all();
    }
}