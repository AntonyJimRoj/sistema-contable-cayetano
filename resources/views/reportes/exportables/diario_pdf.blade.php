<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Diario</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Reporte Diario - {{ $fecha }}</h2>

    <h3>Ingresos</h3>
    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Caja</th>
                <th>Medio de Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ingresos as $i)
                <tr>
                    <td>{{ $i->estudiante->nombre }}</td>
                    <td>{{ $i->concepto->nombre }}</td>
                    <td>S/ {{ number_format($i->monto, 2) }}</td>
                    <td>{{ $i->caja->nombre }}</td>
                    <td>{{ $i->medioPago->nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Egresos</h3>
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Caja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($egresos as $e)
                <tr>
                    <td>{{ $e->concepto_egreso }}</td>
                    <td>S/ {{ number_format($e->monto, 2) }}</td>
                    <td>{{ $e->caja->nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Ingresos:</strong> S/ {{ number_format($totalIngresos, 2) }}</p>
    <p><strong>Total Egresos:</strong> S/ {{ number_format($totalEgresos, 2) }}</p>
    <p><strong>Resultado del Día:</strong> S/ {{ number_format($totalIngresos - $totalEgresos, 2) }}</p>
</body>
</html>
