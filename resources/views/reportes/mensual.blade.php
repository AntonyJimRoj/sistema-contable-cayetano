<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Reporte Mensual de {{ \Carbon\Carbon::parse($mes . '-01')->translatedFormat('F Y') }} 📆
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <!-- Selección de mes -->
        <form method="GET" action="{{ route('reportes.mensual') }}" class="mb-6">
            <label for="mes">Mes:</label>
            <input type="month" name="mes" value="{{ $mes }}" class="border px-2 py-1 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded ml-2">Ver Reporte</button>
        </form>

        <div class="mb-4 flex gap-4">
            <a href="{{ route('reportes.mensual.pdf', ['mes' => $mes]) }}" class="bg-red-600 text-white px-4 py-1 rounded">Exportar PDF</a>
            <a href="{{ route('reportes.mensual.excel', ['mes' => $mes]) }}" class="bg-red-600 text-white px-4 py-1 rounded">Exportar Excel</a>
        </div>


        <!-- INGRESOS -->
        <h3 class="text-lg font-bold mb-2">Ingresos por Curso y Concepto 💰</h3>
        @forelse ($ingresosPorCurso as $curso => $conceptos)
            <div class="mb-4 border p-4 bg-white rounded shadow">
                <h4 class="font-bold mb-2">{{ $curso }}</h4>
                <ul>
                    @foreach ($conceptos as $concepto => $monto)
                        <li>{{ $concepto }}: S/ {{ number_format($monto, 2) }}</li>
                    @endforeach
                    <li class="font-bold mt-2">Total: S/ {{ number_format(array_sum($conceptos), 2) }}</li>
                </ul>
            </div>
        @empty
            <p class="text-gray-600">No hay ingresos registrados este mes.</p>
        @endforelse

        <!-- EGRESOS -->
        <h3 class="text-lg font-bold mt-6 mb-2">Egresos del Mes 🧾</h3>
        <table class="min-w-full bg-white border border-gray-200 mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2">Fecha</th>
                    <th class="px-4 py-2">Concepto</th>
                    <th class="px-4 py-2">Monto</th>
                    <th class="px-4 py-2">Caja</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($egresos as $e)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($e->fecha_egreso)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $e->concepto_egreso }}</td>
                        <td class="px-4 py-2">S/ {{ number_format($e->monto, 2) }}</td>
                        <td class="px-4 py-2">{{ $e->caja->nombre }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center px-4 py-2">No hay egresos.</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- RESUMEN -->
        <h3 class="text-lg font-bold mt-6 mb-2">Resumen por Caja 🏦</h3>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2">Caja</th>
                    <th class="px-4 py-2">Total Ingresos</th>
                    <th class="px-4 py-2">Total Egresos</th>
                    <th class="px-4 py-2">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resumenCajas as $resumen)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $resumen['nombre'] }}</td>
                        <td class="px-4 py-2">S/ {{ number_format($resumen['ingresos'], 2) }}</td>
                        <td class="px-4 py-2">S/ {{ number_format($resumen['egresos'], 2) }}</td>
                        <td class="px-4 py-2 {{ $resumen['saldo'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            S/ {{ number_format($resumen['saldo'], 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
