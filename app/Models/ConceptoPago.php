<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoPago extends Model
{
    protected $table = 'conceptos_pago';

    protected $fillable = [
        'nombre',
        'estado'
    ];

    public $timestamps = true;
}
