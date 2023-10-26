<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bloques', function (Blueprint $table) {
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('notas')->nullable();
            $table->boolean('recordatorio')->default(false);
            $table->boolean('repetible')->default(false);
            $table->string('docente')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bloques', function (Blueprint $table) {
            $table->dropColumn(['titulo', 'descripcion', 'notas', 'recordatorio', 'repetible', 'docente']);
        });
    }
};
