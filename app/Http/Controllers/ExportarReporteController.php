<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Caja;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteDiarioExport;

class ExportarReporteController extends Controller
{
    public function exportarDiarioPDF(Request $request)
    {
        $fecha = $request->input('fecha') ?? date('Y-m-d');

        $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja'])
            ->whereDate('fecha_pago', $fecha)->get();

        $egresos = Egreso::with('caja')->whereDate('fecha_egreso', $fecha)->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('monto');

        $pdf = Pdf::loadView('reportes.exportables.diario_pdf', compact(
            'fecha', 'ingresos', 'egresos', 'totalIngresos', 'totalEgresos'
        ));

        return $pdf->download('reporte_diario_' . $fecha . '.pdf');
    }

    public function exportarDiarioExcel(Request $request)
    {
        $fecha = $request->input('fecha') ?? date('Y-m-d');
        return Excel::download(new ReporteDiarioExport($fecha), 'reporte_diario_' . $fecha . '.xlsx');
    }

    public function exportarMensualPDF(Request $request)
    {
        $mes = $request->input('mes') ?? date('Y-m');

        $ingresos = Ingreso::with(['estudiante.cursos', 'concepto'])
            ->where('fecha_pago', 'like', "$mes%")->get();

        $egresos = Egreso::with('caja')
            ->where('fecha_egreso', 'like', "$mes%")->get();

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

        $resumenCajas = Caja::all()->map(function ($caja) use ($mes) {
            $ing = Ingreso::where('fecha_pago', 'like', "$mes%")->where('caja_id', $caja->id)->sum('monto');
            $egr = Egreso::where('fecha_egreso', 'like', "$mes%")->where('caja_id', $caja->id)->sum('monto');
            return [
                'nombre' => $caja->nombre,
                'ingresos' => $ing,
                'egresos' => $egr,
                'saldo' => $ing - $egr,
            ];
        });

        $pdf = Pdf::loadView('reportes.exportables.mensual_pdf', compact(
            'mes', 'ingresosPorCurso', 'egresos', 'resumenCajas'
        ));

        return $pdf->download('reporte_mensual_' . $mes . '.pdf');
    }

    public function exportarMensualExcel(Request $request)
    {
        $mes = $request->input('mes') ?? date('Y-m');
        return Excel::download(new \App\Exports\ReporteMensualExport($mes), 'reporte_mensual_' . $mes . '.xlsx');
    }

    public function exportarPersonalizadoPDF(Request $request)
    {
        $inicio = $request->input('inicio');
        $fin = $request->input('fin');

        $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja'])
            ->whereBetween('fecha_pago', [$inicio, $fin])->get();

        $egresos = Egreso::with('caja')
            ->whereBetween('fecha_egreso', [$inicio, $fin])->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('monto');

        $pdf = Pdf::loadView('reportes.exportables.personalizado_pdf', compact(
            'inicio', 'fin', 'ingresos', 'egresos', 'totalIngresos', 'totalEgresos'
        ));

        return $pdf->download('reporte_personalizado_' . $inicio . '_al_' . $fin . '.pdf');
    }

    public function exportarPersonalizadoExcel(Request $request)
    {
        $inicio = $request->input('inicio');
        $fin = $request->input('fin');
        return Excel::download(new \App\Exports\ReportePersonalizadoExport($inicio, $fin), 'reporte_personalizado_' . $inicio . '_al_' . $fin . '.xlsx');
    }


}
