<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloquesTable extends Migration
{
    public function up()
    {
        Schema::create('bloques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('tipo'); // Trabajo, Clase, Otros
            $table->string('materia')->nullable(); // Solo para tipo 'Clase'
            $table->string('otros_tipo')->nullable(); // Desayuno, Almuerzo, Cena, Sueño, Actividades diarias
            $table->time('inicio');
            $table->time('fin');
            $table->string('color')->nullable();
            $table->boolean('repetir')->default(false); // Para determinar si se repite a lo largo de la semana
            $table->timestamps();
    
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bloques');
    }
}
