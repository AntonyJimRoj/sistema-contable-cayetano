<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Gestión de Cajas 💼
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <a href="{{ route('cajas.create') }}" class="bg-red-600 text-white px-4 py-2 rounded mb-4 inline-block">
            ➕ Registrar Nueva Caja
        </a>

        <table class="w-full bg-white border shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Saldo Actual</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cajas as $caja)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $caja->nombre }}</td>
                        <td class="px-4 py-2">S/ {{ number_format($caja->saldo, 2) }}</td>                        
                        <td class="px-4 py-2">
                            <form method="POST" action="{{ route('cajas.toggle', $caja->id) }}">
                                @csrf
                                @method('PUT')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-2 text-center">No hay cajas registradas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
