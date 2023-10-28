<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable; // Importa Notifiable

class Usuario extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable, Notifiable; // Utiliza Notifiable junto con los otros traits

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'codigo_estudiante',
        'correo_institucional',
        'password',
        'fecha_creacion',
        'fecha_ultima_modificacion_contraseña'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function bloques()
    {
        return $this->hasMany(Bloque::class);
    }

    public function actividadesEspeciales()
    {
        return $this->hasMany(ActividadEspecial::class);
    }

    public function configuraciones()
    {
        return $this->hasMany(Configuracion::class);
    }

    public function horariosEstudioOptimizados()
    {
        return $this->hasMany(HorarioEstudioOptimizado::class);
    }

    public function notas()
{
    return $this->hasMany(Nota::class);
}

public function getEmailForVerification()
{
    return $this->correo_institucional;
}
}
