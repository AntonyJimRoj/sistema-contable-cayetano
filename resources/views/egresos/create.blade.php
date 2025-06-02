<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Egreso 🧾
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('egresos.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Concepto -->
            <div class="mb-4">
                <label for="concepto_egreso">Concepto</label>
                <input type="text" name="concepto_egreso" class="w-full border rounded" required>
            </div>

            <!-- Monto -->
            <div class="mb-4">
                <label for="monto">Monto</label>
                <input type="number" step="0.01" name="monto" class="w-full border rounded" required>
            </div>

            <!-- Caja -->
            <div class="mb-4">
                <label for="caja_id">Caja</label>
                <select name="caja_id" id="caja_id" class="w-full border rounded">
                    @foreach ($cajas as $caja)
                        <option value="{{ $caja->id }}">{{ $caja->nombre }} (S/ {{ number_format($caja->saldo, 2) }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Imagen -->
            <div class="mb-4">
                <label for="imagen_recibo">Imagen de factura o boleta (opcional)</label>
                <input type="file" name="imagen_recibo" class="w-full">
            </div>

            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Registrar Egreso</button>
        </form>
    </div>
</x-app-layout>
