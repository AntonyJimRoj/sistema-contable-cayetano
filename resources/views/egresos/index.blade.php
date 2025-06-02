<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Egresos 🧾
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <form method="GET" action="{{ route('egresos.index') }}" class="mb-6 flex flex-wrap gap-4">

            <!-- Buscar por concepto -->
            <div>
                <label for="concepto">Buscar Concepto:</label>
                <input type="text" name="concepto" value="{{ request('concepto') }}" placeholder="Ej. sillas, plumones" class="border rounded px-2 py-1">
            </div>

            <!-- Caja -->
            <div>
                <label for="caja_id">Caja:</label>
                <select name="caja_id" class="border rounded px-2 py-1">
                    <option value="">-- Todas --</option>
                    @foreach ($cajas as $caja)
                        <option value="{{ $caja->id }}" {{ request('caja_id') == $caja->id ? 'selected' : '' }}>
                            {{ $caja->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha desde -->
            <div>
                <label for="desde">Desde:</label>
                <input type="date" name="desde" value="{{ request('desde') }}" class="border rounded px-2 py-1">
            </div>

            <!-- Fecha hasta -->
            <div>
                <label for="hasta">Hasta:</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="border rounded px-2 py-1">
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Filtrar</button>
            </div>
        </form>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2">Concepto</th>
                    <th class="px-4 py-2">Monto (S/)</th>
                    <th class="px-4 py-2">Caja</th>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($egresos as $egreso)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $egreso->concepto_egreso }}</td>
                        <td class="px-4 py-2">{{ number_format($egreso->monto, 2) }}</td>
                        <td class="px-4 py-2">{{ $egreso->caja->nombre }}</td>
                        <td class="px-4 py-2">{{ $egreso->usuario->nombre_usuario }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($egreso->fecha_egreso)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $egresos->links() }}
        </div>
    </div>
</x-app-layout>
