<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Crear Nuevo Usuario 👤
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" name="nombre_usuario" class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mb-4">
                <label for="contraseña">Contraseña:</label>
                <input type="password" name="contraseña" class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mb-4">
                <label for="celular">Celular:</label>
                <input type="text" name="celular" class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mb-4">
                <label for="rol_id">Rol:</label>
                <select name="rol_id" class="w-full border rounded px-2 py-1">
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="email">Email (opcional):</label>
                <input type="email" name="email" class="w-full border rounded px-2 py-1">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Crear Usuario
            </button>
        </form>
    </div>
</x-app-layout>
