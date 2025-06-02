<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediosPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        DB::table('medios_pago')->insert([
            ['nombre' => 'Efectivo', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Transferencia', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Yape', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

}
