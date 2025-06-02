<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Personalizado - {{ $inicio }} al {{ $fin }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Reporte Personalizado</h2>
    <p><strong>Desde:</strong> {{ \Carbon\Carbon::parse($inicio)->format('d/m/Y') }} &nbsp; 
       <strong>Hasta:</strong> {{ \Carbon\Carbon::parse($fin)->format('d/m/Y') }}</p>

    <h3>Ingresos</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Estudiante</th>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Caja</th>
                <th>Medio de Pago</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ingresos as $i)
                <tr>
                    <td>{{ $i->fecha_pago }}</td>
                    <td>{{ $i->estudiante->nombre }}</td>
                    <td>{{ $i->concepto->nombre }}</td>
                    <td>S/ {{ number_format($i->monto, 2) }}</td>
                    <td>{{ $i->caja->nombre }}</td>
                    <td>{{ $i->medioPago->nombre }}</td>
                </tr>
            @empty
                <tr><td colspan="6">No hay ingresos registrados en este rango.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Egresos</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Caja</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($egresos as $e)
                <tr>
                    <td>{{ $e->fecha_egreso }}</td>
                    <td>{{ $e->concepto_egreso }}</td>
                    <td>S/ {{ number_format($e->monto, 2) }}</td>
                    <td>{{ $e->caja->nombre }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No hay egresos registrados en este rango.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p><strong>Total Ingresos:</strong> S/ {{ number_format($totalIngresos, 2) }}</p>
    <p><strong>Total Egresos:</strong> S/ {{ number_format($totalEgresos, 2) }}</p>
    <p><strong>Resultado:</strong> S/ {{ number_format($totalIngresos - $totalEgresos, 2) }}</p>
</body>
</html>
