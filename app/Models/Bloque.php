<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    use HasFactory;

    protected $table = 'bloques';

    protected $fillable = [
        'usuario_id', 'tipo', 'materia', 'otros_tipo', 'inicio', 'fin', 'color', 'repetir',
        'titulo', 'notas', 'recordatorio', 'repetible', 'docente'
    ];
    

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
