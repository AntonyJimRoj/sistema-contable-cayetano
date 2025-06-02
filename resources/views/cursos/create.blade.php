<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nuevo Curso 📘
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('cursos.store') }}">
            @csrf

            <!-- Nombre del curso -->
            <div class="mb-4">
                <label for="nombre">Nombre del Curso:</label>
                <input type="text" name="nombre" id="nombre" class="w-full border rounded px-2 py-1" required>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Guardar Curso
            </button>
        </form>
    </div>
</x-app-layout>
