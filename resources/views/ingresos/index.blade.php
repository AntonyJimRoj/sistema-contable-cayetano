<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Ingresos 💰
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <form method="GET" action="{{ route('ingresos.index') }}" class="mb-6 flex flex-wrap gap-4">
            <!-- Buscar por nombre de estudiante -->
            <div>
                <label for="nombre_estudiante">Nombre del Estudiante:</label>
                <input type="text" name="nombre_estudiante" id="nombre_estudiante" value="{{ request('nombre_estudiante') }}" placeholder="Ej. Juan Pérez" class="border rounded px-2 py-1">
            </div>

            <!-- Fecha desde -->
            <div>
                <label for="desde">Desde:</label>
                <input type="date" name="desde" id="desde" value="{{ request('desde') }}" class="border rounded px-2 py-1">
            </div>

            <!-- Fecha hasta -->
            <div>
                <label for="hasta">Hasta:</label>
                <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}" class="border rounded px-2 py-1">
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Filtrar</button>
            </div>
        </form>

        <a href="{{ route('ingresos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + Registrar Ingreso
        </a>


        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2">Estudiante</th>
                    <th class="px-4 py-2">Concepto</th>
                    <th class="px-4 py-2">Monto (S/)</th>
                    <th class="px-4 py-2">Medio</th>
                    <th class="px-4 py-2">Caja</th>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $ingreso)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $ingreso->estudiante->nombre }}</td>
                        <td class="px-4 py-2">{{ $ingreso->concepto->nombre }}</td>
                        <td class="px-4 py-2">{{ number_format($ingreso->monto, 2) }}</td>
                        <td class="px-4 py-2">{{ $ingreso->medioPago->nombre }}</td>
                        <td class="px-4 py-2">{{ $ingreso->caja->nombre }}</td>
                        <td class="px-4 py-2">{{ $ingreso->usuario->nombre_usuario }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($ingreso->fecha_pago)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $ingresos->links() }}
        </div>
    </div>
</x-app-layout>
