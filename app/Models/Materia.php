<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $primaryKey = 'materia_id';
    protected $fillable = ['nombre'];

    public function notas()
{
    return $this->hasMany(Nota::class);
}
}
