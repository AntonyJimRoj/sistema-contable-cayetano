<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Gestión de Medios de Pago 💵
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('medios.store') }}" class="mb-6 flex gap-2">
            @csrf
            <input type="text" name="nombre" placeholder="Nuevo medio..." class="border rounded px-2 py-1 w-full" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Agregar</button>
        </form>

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medios as $m)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $m->nombre }}</td>
                        <td class="px-4 py-2">{{ $m->estado ? 'Activo' : 'Inactivo' }}</td>
                        <td class="px-4 py-2">
                            <form method="POST" action="{{ route('medios.toggle', $m->id) }}">
                                @csrf
                                @method('PUT')
                                <button class="text-blue-600 underline">
                                    {{ $m->estado ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
