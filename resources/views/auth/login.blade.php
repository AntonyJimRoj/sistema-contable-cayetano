<x-guest-layout>
    <div class=" flex items-center justify-center bg-cayetano-dark py-12 px-4">
        <div class="w-full max-w-lg bg-white p-10 rounded-xl shadow-xl">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo_CH.jpg') }}" alt="Logo Cayetano" class="mx-auto h-24 w-24 rounded-full shadow">
                <h2 class="mt-4 text-3xl font-bold text-cayetano-blue">Iniciar Sesión</h2>
                <p class="text-sm text-gray-600">Consorcio Educativo Superior Ramos</p>
            </div>

            <!-- Estado de sesión -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Usuario -->
                <div class="mb-5">
                    <x-input-label for="nombre_usuario" :value="'Nombre de Usuario'" class="text-cayetano-dark" />
                    <x-text-input id="nombre_usuario" class="block mt-1 w-full"
                        type="text" name="nombre_usuario" required autofocus />
                </div>

                <!-- Contraseña -->
                <div class="mb-5">
                    <x-input-label for="password" :value="'Contraseña'" class="text-cayetano-dark" />
                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Botón -->
                <div>
                    <x-primary-button class="w-full bg-cayetano-blue hover:bg-cayetano-light text-white font-bold py-2 px-4 rounded">
                        Ingresar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
