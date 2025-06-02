<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('concepto_id')->constrained('conceptos_pago')->onDelete('restrict');
            $table->decimal('monto', 10, 2);
            $table->foreignId('medio_pago_id')->constrained('medios_pago')->onDelete('restrict');
            $table->timestamp('fecha_pago')->useCurrent(); // fecha actual automática
            $table->foreignId('caja_id')->constrained('cajas')->onDelete('restrict');
            $table->string('codigo_boleta', 50)->nullable(); // opcional
            $table->text('imagen_boleta')->nullable(); // opcional (ruta imagen)
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade'); // quien registró
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos');
    }
};
