<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadEspecial extends Model
{
    use HasFactory;

    protected $table = 'actividades_especiales';

    protected $fillable = [
        'usuario_id',
        'descripcion',
        'inicio',
        'fin',
        'fecha',
        'repetir_semanalmente',
        'notas'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
