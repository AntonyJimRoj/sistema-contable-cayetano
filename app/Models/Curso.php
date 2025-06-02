<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
    ];

    public $timestamps = true;

    // Relación con estudiantes (N:N)
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'curso_estudiante');
    }
}
