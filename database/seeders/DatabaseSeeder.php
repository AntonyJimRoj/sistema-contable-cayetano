<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(CajasSeeder::class);
        $this->call(ConceptosPagoSeeder::class);
        $this->call(MediosPagoSeeder::class);
        $this->call(CursosSeeder::class);
        $this->call(EstudiantesSeeder::class);
        $this->call(CursoEstudianteSeeder::class);
        
    }
}
