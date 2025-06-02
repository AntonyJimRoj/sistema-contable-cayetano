<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Reporte Personalizado 🧠
        </h2>
    </x-slot>

    @php
        $inicio = $inicio ?? null;
        $fin = $fin ?? null;
    @endphp

    <div class="py-6 max-w-7xl mx-auto">

        <form method="GET" action="{{ route('reportes.personalizado') }}" class="mb-6 flex gap-4 items-end flex-wrap">
            <div>
                <label for="desde">Desde:</label>
                <input type="date" name="desde" value="{{ $desde ?? '' }}" class="border rounded px-2 py-1">
            </div>

            <div>
                <label for="hasta">Hasta:</label>
                <input type="date" name="hasta" value="{{ $hasta ?? '' }}" class="border rounded px-2 py-1">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Generar Reporte</button>
        </form>

        @if ($desde && $hasta)
            <div class="mb-4 flex gap-4">
                <a href="{{ route('reportes.personalizado.pdf', ['inicio' => $desde, 'fin' => $hasta]) }}"
                   class="bg-red-600 text-white px-4 py-1 rounded">Exportar PDF</a>

                <a href="{{ route('reportes.personalizado.excel', ['inicio' => $desde, 'fin' => $hasta]) }}"
                   class="bg-red-600 text-white px-4 py-1 rounded">Exportar Excel</a>
            </div>
        @endif

        @if ($desde && $hasta)
            <div class="mb-6">
                <h3 class="font-bold text-lg">Rango: {{ $desde }} al {{ $hasta }}</h3>
            </div>

            <h4 class="text-lg font-bold">Ingresos 💰</h4>
            <table class="min-w-full bg-white border mb-6">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Estudiante</th>
                        <th class="px-4 py-2">Concepto</th>
                        <th class="px-4 py-2">Monto</th>
                        <th class="px-4 py-2">Caja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ingresos as $i)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($i->fecha_pago)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $i->estudiante->nombre }}</td>
                            <td class="px-4 py-2">{{ $i->concepto->nombre }}</td>
                            <td class="px-4 py-2">S/ {{ number_format($i->monto, 2) }}</td>
                            <td class="px-4 py-2">{{ $i->caja->nombre }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center px-4 py-2">Sin ingresos en este rango.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <h4 class="text-lg font-bold">Egresos 🧾</h4>
            <table class="min-w-full bg-white border mb-6">
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
                        <tr><td colspan="4" class="text-center px-4 py-2">Sin egresos en este rango.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-lg font-bold">
                Total Ingresos: S/ {{ number_format($totalIngresos, 2) }}<br>
                Total Egresos: S/ {{ number_format($totalEgresos, 2) }}<br>
                <span class="{{ ($totalIngresos - $totalEgresos) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Resultado: S/ {{ number_format($totalIngresos - $totalEgresos, 2) }}
                </span>
            </div>
        @endif
    </div>
</x-app-layout>
