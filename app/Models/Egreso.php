<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = 'egresos';

    protected $fillable = [
        'concepto_egreso',
        'monto',
        'fecha_egreso',
        'caja_id',
        'imagen_recibo',
        'usuario_id',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public $timestamps = true;
}
