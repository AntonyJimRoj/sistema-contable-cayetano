<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cursos Ofrecidos 🎓
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('cursos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + Nuevo Curso
        </a>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre del Curso</th>
                    <th class="px-4 py-2"># Estudiantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $curso->nombre }}</td>
                        <td class="px-4 py-2">{{ $curso->estudiantes_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $cursos->links() }}
        </div>
    </div>
</x-app-layout>
