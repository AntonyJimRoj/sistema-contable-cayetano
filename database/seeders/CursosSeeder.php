<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('cursos')->insert([
            ['nombre' => 'Computación', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gastronomía', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Inglés Básico', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

}
