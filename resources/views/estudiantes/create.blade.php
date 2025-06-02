<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Estudiante 🎓
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('estudiantes.store') }}">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="w-full border rounded px-2 py-1" required>
            </div>

            <!-- DNI -->
            <div class="mb-4">
                <label for="dni">DNI o Carnet de Extranjería:</label>
                <input type="text" name="dni" id="dni" class="w-full border rounded px-2 py-1">
            </div>

            <!-- Celular -->
            <div class="mb-4">
                <label for="celular">Número de Celular:</label>
                <input type="text" name="celular" id="celular" class="w-full border rounded px-2 py-1">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Guardar Estudiante
            </button>
        </form>
    </div>
</x-app-layout>
