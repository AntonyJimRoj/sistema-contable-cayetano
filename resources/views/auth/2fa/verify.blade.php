<x-app-layout>
    <div class="py-8 max-w-md mx-auto text-center">
        <h2 class="text-2xl font-bold mb-4">Verificación en Dos Pasos 🔐</h2>

        @if ($errors->any())
            <div class="text-red-600 mb-4">
                {{ $errors->first('code') }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf
            <input type="text" name="code" placeholder="Código 2FA" class="border rounded px-4 py-2 mb-4 w-full text-center" autofocus>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Verificar Código
            </button>
        </form>
    </div>
</x-app-layout>
