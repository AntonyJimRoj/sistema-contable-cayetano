<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoEstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        DB::table('curso_estudiante')->insert([
            ['estudiante_id' => 1, 'curso_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Juan - Computación
            ['estudiante_id' => 1, 'curso_id' => 2, 'created_at' => now(), 'updated_at' => now()], // Juan - Gastronomía
            ['estudiante_id' => 2, 'curso_id' => 2, 'created_at' => now(), 'updated_at' => now()], // María - Gastronomía
            ['estudiante_id' => 3, 'curso_id' => 3, 'created_at' => now(), 'updated_at' => now()], // Luis - Inglés Básico
        ]);
    }

}
