<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasTable extends Migration
{
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // El nombre de la materia debe ser único
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materias');
    }
}
