<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\Ingreso;
use App\Models\Egreso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ReporteDiarioExport implements FromCollection, WithHeadings
{
    protected $fecha;

    public function __construct($fecha)
    {
        $this->fecha = $fecha;
    }

    public function collection()
    {
        $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja'])
            ->whereDate('fecha_pago', $this->fecha)->get()
            ->map(function ($i) {
                return [
                    'Tipo' => 'Ingreso',
                    'Fecha' => $i->fecha_pago,
                    'Nombre' => $i->estudiante->nombre,
                    'Concepto' => $i->concepto->nombre,
                    'Monto' => $i->monto,
                    'Caja' => $i->caja->nombre,
                    'Medio de Pago' => $i->medioPago->nombre,
                ];
            });

        $egresos = Egreso::with('caja')
            ->whereDate('fecha_egreso', $this->fecha)->get()
            ->map(function ($e) {
                return [
                    'Tipo' => 'Egreso',
                    'Fecha' => $e->fecha_egreso,
                    'Nombre' => null,
                    'Concepto' => $e->concepto_egreso,
                    'Monto' => $e->monto,
                    'Caja' => $e->caja->nombre,
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
