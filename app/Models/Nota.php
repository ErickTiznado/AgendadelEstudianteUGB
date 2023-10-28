<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = ['titulo', 'contenido', 'materia', 'fecha', 'usuario_id'];


    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    public function materiaRelacion(){
        return $this->belongsTo(Materia::class, 'materia');
    }
    

}
