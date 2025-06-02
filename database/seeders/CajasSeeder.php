<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CajasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cajas')->insert([
            ['nombre' => 'Caja Grande', 'saldo' => 1000.00, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Caja Chica', 'saldo' => 300.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
