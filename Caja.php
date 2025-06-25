<?php
namespace App\Services;

use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Caja;

class ReporteService
{
    public static function resumenPorCaja($mes)
    {
        $cajas = Caja::all();
        $resumen = [];

        foreach ($cajas as $caja) {
            $ingresos = Ingreso::where('fecha_pago', 'like', $mes . '%')
                ->where('caja_id', $caja->id)
                ->sum('monto');

            $egresos = Egreso::where('fecha_egreso', 'like', $mes . '%')
                ->where('caja_id', $caja->id)
                ->sum('monto');

            $resumen[] = [
                'nombre' => $caja->nombre,
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'saldo' => $ingresos - $egresos,
            ];
        }

        return $resumen;
    }
}