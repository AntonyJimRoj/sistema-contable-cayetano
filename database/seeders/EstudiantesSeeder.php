<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudiantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        DB::table('estudiantes')->insert([
            ['nombre' => 'Juan Pérez', 'dni' => '12345678', 'celular' => '987111222', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'María López', 'dni' => '87654321', 'celular' => '987222333', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Luis Fernández', 'dni' => null, 'celular' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

}
