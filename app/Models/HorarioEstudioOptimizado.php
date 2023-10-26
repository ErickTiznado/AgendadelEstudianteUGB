<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioEstudioOptimizado extends Model
{
    use HasFactory;

    protected $table = 'horario_estudio_optimizado';

    protected $fillable = [
        'usuario_id',
        'materia',
        'horas_estudio',
        'prioridad',
        'tecnica_estudio_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function tecnicaEstudio()
    {
        return $this->belongsTo(TecnicaGestionTiempo::class, 'tecnica_estudio_id');
    }
}
