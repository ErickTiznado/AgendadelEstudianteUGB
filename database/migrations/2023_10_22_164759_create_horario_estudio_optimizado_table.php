<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioEstudioOptimizadoTable extends Migration
{
    public function up()
    {
        Schema::create('horario_estudio_optimizado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->string('materia');
            $table->integer('horas_estudio');
            $table->integer('prioridad');
            $table->foreignId('tecnica_estudio_id')->constrained('tecnicas_gestion_tiempo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('horario_estudio_optimizado');
    }
}
