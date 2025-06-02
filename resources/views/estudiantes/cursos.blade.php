<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Asignar Cursos a {{ $estudiante->nombre }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('estudiantes.asignarCursos', $estudiante->id) }}">
            @csrf

            <div class="mb-4">
                @foreach ($cursos as $curso)
                    <div>
                        <label>
                            <input type="checkbox" name="cursos[]" value="{{ $curso->id }}"
                                {{ in_array($curso->id, $cursosAsignados) ? 'checked' : '' }}>
                            {{ $curso->nombre }}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Guardar Cursos
            </button>
        </form>
    </div>
</x-app-layout>
