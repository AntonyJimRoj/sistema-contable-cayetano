<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConceptosPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conceptos_pago')->insert([
            ['nombre' => 'Inscripción', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Matrícula', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mensualidad', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Certificado', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
