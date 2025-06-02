<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Registrar Nueva Caja 🏦
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <form method="POST" action="{{ route('cajas.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block mb-1 font-semibold">Nombre de la Caja:</label>
                <input type="text" name="nombre" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="saldo" class="block mb-1 font-semibold">Saldo Inicial:</label>
                <input type="number" step="0.01" name="saldo" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">
                Crear Caja
            </button>
        </form>
    </div>
</x-app-layout>
