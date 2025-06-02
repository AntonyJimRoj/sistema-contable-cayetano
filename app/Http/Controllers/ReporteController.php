<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Estudiante;
use App\Models\Curso;
use App\Models\Caja;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function reporteDiario(Request $request)
    {
        $fecha = $request->input('fecha') ?? date('Y-m-d');

        $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja'])
            ->whereDate('fecha_pago', $fecha)
            ->get();

        $egresos = Egreso::with(['caja'])
            ->whereDate('fecha_egreso', $fecha)
            ->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('monto');

        return view('reportes.diario', compact('fecha', 'ingresos', 'egresos', 'totalIngresos', 'totalEgresos'));
    }

    public function reporteMensual(Request $request)
    {
        $mes = $request->input('mes') ?? date('Y-m');

        // Obtener ingresos del mes
        $ingresos = Ingreso::with(['estudiante.cursos', 'concepto'])
            ->where('fecha_pago', 'like', $mes . '%')
            ->get();

        // Agrupar por curso y concepto
        $ingresosPorCurso = [];

        foreach ($ingresos as $ingreso) {
            foreach ($ingreso->estudiante->cursos as $curso) {
                $cursoNombre = $curso->nombre;
                $concepto = $ingreso->concepto->nombre;
                $monto = $ingreso->monto;

                if (!isset($ingresosPorCurso[$cursoNombre])) {
                    $ingresosPorCurso[$cursoNombre] = [];
                }

                if (!isset($ingresosPorCurso[$cursoNombre][$concepto])) {
                    $ingresosPorCurso[$cursoNombre][$concepto] = 0;
                }

                $ingresosPorCurso[$cursoNombre][$concepto] += $monto;
            }
        }

        // Obtener egresos del mes
        $egresos = Egreso::with('caja')
            ->where('fecha_egreso', 'like', $mes . '%')
            ->get();

        // Calcular resumen por caja
        $cajas = Caja::all();
        $resumenCajas = [];

        foreach ($cajas as $caja) {
            $ingresosCaja = Ingreso::where('fecha_pago', 'like', $mes . '%')->where('caja_id', $caja->id)->sum('monto');
            $egresosCaja = Egreso::where('fecha_egreso', 'like', $mes . '%')->where('caja_id', $caja->id)->sum('monto');

            $resumenCajas[] = [
                'nombre' => $caja->nombre,
                'ingresos' => $ingresosCaja,
                'egresos' => $egresosCaja,
                'saldo' => $ingresosCaja - $egresosCaja,
            ];
        }

        return view('reportes.mensual', compact('mes', 'ingresosPorCurso', 'egresos', 'resumenCajas'));
    }

    public function reportePersonalizado(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        $ingresos = collect();
        $egresos = collect();
        $totalIngresos = 0;
        $totalEgresos = 0;

        if ($desde && $hasta) {
            $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja'])
                ->whereBetween('fecha_pago', [$desde, $hasta])
                ->get();

            $egresos = Egreso::with('caja')
                ->whereBetween('fecha_egreso', [$desde, $hasta])
                ->get();

            $totalIngresos = $ingresos->sum('monto');
            $totalEgresos = $egresos->sum('monto');
        }

        return view('reportes.personalizado', compact('desde', 'hasta', 'ingresos', 'egresos', 'totalIngresos', 'totalEgresos'));
    }

}
