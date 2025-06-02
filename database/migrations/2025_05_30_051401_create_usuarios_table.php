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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre_usuario', 100)->unique(); // nombre de usuario
            $table->string('contraseña'); // contraseña en hash
            $table->string('celular', 15); // para 2FA
            $table->string('email', 100)->nullable(); // opcional
            $table->foreignId('rol_id')->constrained('roles')->onDelete('cascade'); // FK
            $table->boolean('estado')->default(true); // activo/inactivo
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
        Schema::dropIfExists('usuarios');
    }
};
