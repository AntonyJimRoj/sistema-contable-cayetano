<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\Ingreso;
use App\Models\Egreso;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportePersonalizadoExport implements FromCollection, WithHeadings
{
    protected $desde;
    protected $hasta;

    public function __construct($desde, $hasta)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function collection()
    {
        $ingresos = Ingreso::with(['estudiante', 'concepto', 'caja', 'medioPago'])
            ->whereBetween('fecha_pago', [$this->desde, $this->hasta])->get()
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
            ->whereBetween('fecha_egreso', [$this->desde, $this->hasta])->get()
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
