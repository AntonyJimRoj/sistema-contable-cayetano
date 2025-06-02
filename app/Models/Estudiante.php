<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre',
        'dni',
        'celular'
    ];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiante');
    }


    public $timestamps = true;
}
