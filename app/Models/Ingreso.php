<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';

    protected $fillable = [
        'estudiante_id',
        'concepto_id',
        'monto',
        'medio_pago_id',
        'fecha_pago',
        'caja_id',
        'codigo_boleta',
        'imagen_boleta',
        'usuario_id'
    ];

    public $timestamps = true;

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function concepto()
    {
        return $this->belongsTo(ConceptoPago::class, 'concepto_id');
    }

    public function medioPago()
    {
        return $this->belongsTo(MedioPago::class, 'medio_pago_id');
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

}


