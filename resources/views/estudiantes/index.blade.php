<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Estudiantes Registrados 🎓
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('estudiantes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + Nuevo Estudiante
        </a>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">DNI</th>
                    <th class="px-4 py-2">Celular</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estudiantes as $e)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $e->nombre }}</td>
                        <td class="px-4 py-2">{{ $e->dni ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $e->celular ?? '—' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('estudiantes.cursos', $e->id) }}" class="text-blue-600 underline">Asignar Cursos</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $estudiantes->links() }}
        </div>
    </div>
</x-app-layout>
