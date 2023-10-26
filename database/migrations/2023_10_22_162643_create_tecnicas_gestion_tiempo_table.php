<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTecnicasGestionTiempoTable extends Migration
{
    public function up()
    {
        Schema::create('tecnicas_gestion_tiempo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->json('parametros')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tecnicas_gestion_tiempo');
    }
}
