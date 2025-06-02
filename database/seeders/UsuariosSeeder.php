<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'nombre_usuario' => 'admin',
                'contraseña' => Hash::make('admin123'),
                'celular' => '987654321',
                'email' => 'admin@cayetano.edu.pe',
                'rol_id' => 1, // Administrador
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre_usuario' => 'contador',
                'contraseña' => Hash::make('contador123'),
                'celular' => '912345678',
                'email' => null,
                'rol_id' => 2, // Contador General
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
