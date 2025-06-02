<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Ingreso 💰
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('ingresos.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Estudiante -->
            <div class="mb-4">
                <label for="estudiante_id">Estudiante</label>
                <select name="estudiante_id" id="estudiante_id" class="w-full border rounded">
                    @foreach ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}">{{ $estudiante->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Concepto -->
            <div class="mb-4">
                <label for="concepto_id">Concepto</label>
                <select name="concepto_id" id="concepto_id" class="w-full border rounded">
                    @foreach ($conceptos as $concepto)
                        <option value="{{ $concepto->id }}">{{ $concepto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Monto -->
            <div class="mb-4">
                <label for="monto">Monto</label>
                <input type="number" step="0.01" name="monto" class="w-full border rounded" required>
            </div>

            <!-- Medio de pago -->
            <div class="mb-4">
                <label for="medio_pago_id">Medio de Pago</label>
                <select name="medio_pago_id" id="medio_pago_id" class="w-full border rounded">
                    @foreach ($medios as $medio)
                        <option value="{{ $medio->id }}">{{ $medio->nombre }}</option>
                    @endforeach
                </select>
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

            <!-- Código de boleta -->
            <div class="mb-4">
                <label for="codigo_boleta">Código de Boleta (opcional)</label>
                <input type="text" name="codigo_boleta" class="w-full border rounded">
            </div>

            <!-- Imagen -->
            <div class="mb-4">
                <label for="imagen_boleta">Imagen de boleta (opcional)</label>
                <input type="file" name="imagen_boleta" class="w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Ingreso</button>
        </form>
    </div>
</x-app-layout>
