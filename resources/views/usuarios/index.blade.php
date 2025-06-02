<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Gestión de Usuarios 👥
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('usuarios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Nuevo Usuario</a>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Rol</th>
                    <th class="px-4 py-2">Celular</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">2FA</th> {{-- NUEVA COLUMNA --}}
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $u)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $u->nombre_usuario }}</td>
                        <td class="px-4 py-2">{{ $u->rol->nombre }}</td>
                        <td class="px-4 py-2">{{ $u->celular }}</td>
                        <td class="px-4 py-2">{{ $u->email ?? '—' }}</td>

                        <td class="px-4 py-2">
                            @if ($u->google2fa_secret)
                                <form method="POST" action="{{ route('admin.desactivar2fa', $u->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button class="text-red-600 underline" onclick="return confirm('¿Desactivar 2FA para este usuario?')">
                                        Desactivar 2FA
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.activar2fa', $u->id) }}"
                                class="text-blue-600 underline">Activar 2FA</a>
                            @endif
                        </td>

                        <td class="px-4 py-2">
                            <a href="{{ route('usuarios.edit', $u->id) }}" class="text-blue-600 underline">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    </div>
</x-app-layout>
