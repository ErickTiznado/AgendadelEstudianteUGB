<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;


class Usuario extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

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
}
