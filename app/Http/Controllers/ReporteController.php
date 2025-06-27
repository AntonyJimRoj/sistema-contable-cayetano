<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Caja;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function reporteDiario(Request $request)
    {
        $fecha = $request->input('fecha') ?? now()->toDateString();

        [$ingresos, $egresos, $totalIngresos, $totalEgresos] = $this->obtenerTransaccionesPorFecha($fecha);

        return view('reportes.diario', compact('fecha', 'ingresos', 'egresos', 'totalIngresos', 'totalEgresos'));
    }

    public function reporteMensual(Request $request)
    {
        $mes = $request->input('mes') ?? now()->format('Y-m');

        $ingresos = Ingreso::with(['estudiante.cursos', 'concepto'])
            ->where('fecha_pago', 'like', "$mes%")
            ->get();

        $ingresosPorCurso = $this->agruparIngresosPorCursoYConcepto($ingresos);

        $egresos = Egreso::with('caja')
            ->where('fecha_egreso', 'like', "$mes%")
            ->get();

        $resumenCajas = $this->obtenerResumenPorCaja($mes);

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
            [$ingresos, $egresos, $totalIngresos, $totalEgresos] = $this->obtenerTransaccionesEntreFechas($desde, $hasta);
        }

        return view('reportes.personalizado', compact('desde', 'hasta', 'ingresos', 'egresos', 'totalIngresos', 'totalEgresos'));
    }

    // 🔁 Métodos reutilizables (evitan repetición de código)
    private function obtenerTransaccionesPorFecha($fecha)
    {
        $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja'])
            ->whereDate('fecha_pago', $fecha)->get();

        $egresos = Egreso::with('caja')
            ->whereDate('fecha_egreso', $fecha)->get();

        return [$ingresos, $egresos, $ingresos->sum('monto'), $egresos->sum('monto')];
    }

    private function obtenerTransaccionesEntreFechas($desde, $hasta)
    {
        $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja'])
            ->whereBetween('fecha_pago', [$desde, $hasta])->get();

        $egresos = Egreso::with('caja')
            ->whereBetween('fecha_egreso', [$desde, $hasta])->get();

        return [$ingresos, $egresos, $ingresos->sum('monto'), $egresos->sum('monto')];
    }

    private function agruparIngresosPorCursoYConcepto($ingresos)
    {
        $resultado = [];

        foreach ($ingresos as $ingreso) {
            foreach ($ingreso->estudiante->cursos as $curso) {
                $cursoNombre = $curso->nombre;
                $concepto = $ingreso->concepto->nombre;
                $monto = $ingreso->monto;

                $resultado[$cursoNombre][$concepto] = ($resultado[$cursoNombre][$concepto] ?? 0) + $monto;
            }
        }

        return $resultado;
    }

    private function obtenerResumenPorCaja($mes)
    {
        return Caja::all()->map(function ($caja) use ($mes) {
            $ingresos = Ingreso::where('fecha_pago', 'like', "$mes%")
                ->where('caja_id', $caja->id)->sum('monto');

            $egresos = Egreso::where('fecha_egreso', 'like', "$mes%")
                ->where('caja_id', $caja->id)->sum('monto');

            return [
                'nombre' => $caja->nombre,
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'saldo' => $ingresos - $egresos,
            ];
        })->toArray();
    }
}
