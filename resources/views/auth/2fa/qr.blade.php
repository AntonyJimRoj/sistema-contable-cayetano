<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Activar Verificación en Dos Pasos 🔐
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto text-center">
        <p class="mb-4">
            Escanea este código QR con Google Authenticator, Authy u otra app compatible:
        </p>

        <div class="mb-6">
            {!! $QR_Image !!}
        </div>

        <p class="text-sm mb-2">
            Si no puedes escanear el código, puedes ingresar manualmente esta clave secreta en tu app:
        </p>

        <div class="font-mono bg-gray-100 border rounded px-4 py-2 inline-block mb-6">
            {{ $secret }}
        </div>

        <p class="text-green-600 font-semibold">
            ✅ Verificación en dos pasos activada. Ahora, cuando inicies sesión, se te pedirá el código de tu app.
        </p>
    </div>
</x-app-layout>
