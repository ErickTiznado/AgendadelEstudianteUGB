<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesEspecialesTable extends Migration
{
    public function up()
    {
        Schema::create('actividades_especiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->text('descripcion');
            $table->time('inicio');
            $table->time('fin');
            $table->date('fecha');
            $table->boolean('repetir_semanalmente')->default(false);
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actividades_especiales');
    }
}
