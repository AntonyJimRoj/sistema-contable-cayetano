<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Rol;
use PragmaRX\Google2FALaravel\Support\Authenticator;


class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios'; // ← nombre real de tu tabla

    protected $fillable = [
        'nombre_usuario',
        'contraseña',
        'celular',
        'email',
        'rol_id',
        'estado',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }


    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}
