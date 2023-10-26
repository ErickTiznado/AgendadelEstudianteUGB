<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuraciones';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'valor'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
