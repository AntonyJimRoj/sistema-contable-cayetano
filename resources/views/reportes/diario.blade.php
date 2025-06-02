<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Reporte Diario del {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }} 📅
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <!-- Formulario de selección de fecha -->
        <form method="GET" action="{{ route('reportes.diario') }}" class="mb-6">
            <label for="fecha">Seleccionar Fecha:</label>
            <input type="date" name="fecha" value="{{ $fecha }}" class="border px-2 py-1 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded ml-2">Buscar</button>
        </form>

        <div class="mb-4 flex gap-4">
            <a href="{{ route('reportes.diario.pdf', ['fecha' => $fecha]) }}" class="bg-red-600 text-white px-4 py-1 rounded">Exportar PDF</a>
            <a href="{{ route('reportes.diario.excel', ['fecha' => $fecha]) }}" class="bg-red-600 text-white px-4 py-1 rounded">Exportar Excel</a>
        </div>


        <h3 class="text-lg font-bold mb-2">Ingresos 💰</h3>
        <table class="min-w-full bg-white border border-gray-200 mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2">Estudiante</th>
                    <th class="px-4 py-2">Concepto</th>
                    <th class="px-4 py-2">Monto</th>
                    <th class="px-4 py-2">Medio de Pago</th>
                    <th class="px-4 py-2">Caja</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ingresos as $i)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $i->estudiante->nombre }}</td>
                        <td class="px-4 py-2">{{ $i->concepto->nombre }}</td>
                        <td class="px-4 py-2">S/ {{ number_format($i->monto, 2) }}</td>
                        <td class="px-4 py-2">{{ $i->medioPago->nombre }}</td>
                        <td class="px-4 py-2">{{ $i->caja->nombre }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-2 text-center">No hay ingresos.</td></tr>
                @endforelse
            </tbody>
        </table>

        <h3 class="text-lg font-bold mb-2">Egresos 🧾</h3>
        <table class="min-w-full bg-white border border-gray-200 mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2">Concepto</th>
                    <th class="px-4 py-2">Monto</th>
                    <th class="px-4 py-2">Caja</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($egresos as $e)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $e->concepto_egreso }}</td>
                        <td class="px-4 py-2">S/ {{ number_format($e->monto, 2) }}</td>
                        <td class="px-4 py-2">{{ $e->caja->nombre }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-2 text-center">No hay egresos.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4 text-lg font-bold">
            Total Ingresos: S/ {{ number_format($totalIngresos, 2) }}<br>
            Total Egresos: S/ {{ number_format($totalEgresos, 2) }}<br>
            <span class="{{ $totalIngresos - $totalEgresos >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Resultado del Día: S/ {{ number_format($totalIngresos - $totalEgresos, 2) }}
            </span>
        </div>
    </div>
</x-app-layout>
