<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-cayetano-dark to-cayetano-blue text-white border-r border-cayetano-light">
            <div class="p-6 font-bold text-xl tracking-wide border-b border-cayetano-light">
                Contador 📊
            </div>
            <nav class="flex flex-col gap-1 py-4 text-sm font-medium px-3">
                <a href="{{ route('ingresos.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-cayetano-light hover:text-white transition">
                    💰 <span>Ingresos</span>
                </a>
                <a href="{{ route('egresos.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-cayetano-light hover:text-white transition">
                    🧾 <span>Egresos</span>
                </a>
                <hr class="my-2 border-cayetano-light">
                <a href="{{ route('reportes.diario') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-cayetano-light hover:text-white transition">
                    📆 <span>Reporte Diario</span>
                </a>
                <a href="{{ route('reportes.mensual') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-cayetano-light hover:text-white transition">
                    📊 <span>Reporte Mensual</span>
                </a>
                <a href="{{ route('reportes.personalizado') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-cayetano-light hover:text-white transition">
                    🧠 <span>Reporte Personalizado</span>
                </a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-8 bg-gray-50">
            <h1 class="text-3xl font-bold text-cayetano-dark mb-6">Resumen Contable 📑</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow border-l-8 border-green-500 p-4">
                    <p class="text-gray-600 text-sm">Ingresos del Mes</p>
                    <p class="text-2xl font-extrabold text-green-700">S/ {{ number_format($ingresosMes, 2) }}</p>
                </div>

                <div class="bg-white rounded-xl shadow border-l-8 border-red-500 p-4">
                    <p class="text-gray-600 text-sm">Egresos del Mes</p>
                    <p class="text-2xl font-extrabold text-red-700">S/ {{ number_format($egresosMes, 2) }}</p>
                </div>
            </div>

            <div class="mt-10">
                <h2 class="text-2xl font-semibold text-cayetano-dark mb-4">Saldo por Caja 🏦</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($cajas as $caja)
                        <div class="bg-white border-l-8 border-cayetano-blue shadow rounded-xl p-4">
                            <p class="text-cayetano-dark text-sm font-medium">{{ $caja->nombre }}</p>
                            <p class="text-xl font-bold text-gray-800">S/ {{ number_format($caja->saldo, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
