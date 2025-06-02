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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto_egreso', 200); // descripción del gasto
            $table->decimal('monto', 10, 2);
            $table->timestamp('fecha_egreso')->useCurrent(); // automática
            $table->foreignId('caja_id')->constrained('cajas')->onDelete('restrict');
            $table->text('imagen_recibo')->nullable(); // opcional
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
        Schema::dropIfExists('egresos');
    }
};
