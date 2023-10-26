<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TecnicaGestionTiempo extends Model
{
    use HasFactory;

    protected $table = 'tecnicas_gestion_tiempo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'parametros'
    ];
}
