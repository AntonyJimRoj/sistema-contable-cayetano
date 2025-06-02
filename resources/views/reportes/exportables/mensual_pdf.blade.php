<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Mensual - {{ $mes }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Reporte Mensual - {{ \Carbon\Carbon::parse($mes . '-01')->translatedFormat('F Y') }}</h2>

    <h3>Ingresos por Curso y Concepto</h3>
    @forelse ($ingresosPorCurso as $curso => $conceptos)
        <table>
            <thead>
                <tr>
                    <th colspan="2">{{ $curso }}</th>
                </tr>
                <tr>
                    <th>Concepto</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conceptos as $concepto => $monto)
                    <tr>
                        <td>{{ $concepto }}</td>
                        <td>S/ {{ number_format($monto, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>S/ {{ number_format(array_sum($conceptos), 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    @empty
        <p>No hay ingresos registrados para este mes.</p>
    @endforelse

    <h3>Egresos del Mes</h3>
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
                    <td>{{ \Carbon\Carbon::parse($e->fecha_egreso)->format('d/m/Y') }}</td>
                    <td>{{ $e->concepto_egreso }}</td>
                    <td>S/ {{ number_format($e->monto, 2) }}</td>
                    <td>{{ $e->caja->nombre }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No hay egresos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Resumen por Caja</h3>
    <table>
        <thead>
            <tr>
                <th>Caja</th>
                <th>Total Ingresos</th>
                <th>Total Egresos</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resumenCajas as $caja)
                <tr>
                    <td>{{ $caja['nombre'] }}</td>
                    <td>S/ {{ number_format($caja['ingresos'], 2) }}</td>
                    <td>S/ {{ number_format($caja['egresos'], 2) }}</td>
                    <td>S/ {{ number_format($caja['saldo'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
