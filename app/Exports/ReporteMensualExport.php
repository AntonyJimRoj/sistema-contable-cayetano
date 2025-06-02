<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\Ingreso;
use App\Models\Egreso;

class ReporteMensualExport implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings
{
    protected $mes;

    public function __construct($mes)
    {
        $this->mes = $mes;
    }

    public function collection()
    {
        $ingresos = Ingreso::with(['estudiante', 'concepto', 'caja', 'medioPago'])
            ->where('fecha_pago', 'like', "$this->mes%")->get()
            ->map(function ($i) {
                return [
                    'Tipo' => 'Ingreso',
                    'Fecha' => $i->fecha_pago,
                    'Nombre' => $i->estudiante->nombre ?? '',
                    'Concepto' => $i->concepto->nombre ?? '',
                    'Monto' => $i->monto,
                    'Caja' => $i->caja->nombre ?? '',
                    'Medio de Pago' => $i->medioPago->nombre ?? '',
                ];
            });

        $egresos = Egreso::with('caja')
            ->where('fecha_egreso', 'like', "$this->mes%")->get()
            ->map(function ($e) {
                return [
                    'Tipo' => 'Egreso',
                    'Fecha' => $e->fecha_egreso,
                    'Nombre' => null,
                    'Concepto' => $e->concepto_egreso,
                    'Monto' => $e->monto,
                    'Caja' => $e->caja->nombre ?? '',
                    'Medio de Pago' => null,
                ];
            });

        return $ingresos->merge($egresos);
    }

    public function headings(): array
    {
        return ['Tipo', 'Fecha', 'Nombre', 'Concepto', 'Monto', 'Caja', 'Medio de Pago'];
    }
}
