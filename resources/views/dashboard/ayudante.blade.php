<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-cayetano-dark to-cayetano-blue text-white border-r border-cayetano-light">
            <div class="p-6 font-bold text-xl tracking-wide border-b border-white/20">
                Ayudante 👨‍💼
            </div>
            <nav class="flex flex-col gap-2 py-4 px-3 text-sm font-medium">
                <a href="{{ route('ingresos.create') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-white/10 hover:text-white transition">
                    💰 <span>Registrar Ingreso</span>
                </a>

                <a href="{{ route('egresos.create') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-white/10 hover:text-white transition">
                    🧾 <span>Registrar Egreso</span>
                </a>

                <hr class="my-2 border-white/20">

                <a href="{{ route('reportes.diario') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-white/10 hover:text-white transition">
                    📆 <span>Ver Reporte Diario</span>
                </a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-8 bg-gray-50">
            <h1 class="text-3xl font-bold text-cayetano-dark mb-6">
                Actividad de Hoy 🗓️ ({{ \Carbon\Carbon::parse($hoy)->format('d/m/Y') }})
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow border-l-8 border-green-500 p-4">
                    <p class="text-gray-600 text-sm">Ingresos Registrados</p>
                    <p class="text-2xl font-extrabold text-green-700">{{ $ingresosHoy }}</p>
                </div>

                <div class="bg-white rounded-xl shadow border-l-8 border-red-500 p-4">
                    <p class="text-gray-600 text-sm">Egresos Registrados</p>
                    <p class="text-2xl font-extrabold text-red-700">{{ $egresosHoy }}</p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
