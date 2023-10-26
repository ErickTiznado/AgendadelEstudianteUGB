<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('codigo_estudiante')->unique();
            $table->string('correo_institucional')->unique();
            $table->string('password');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_ultima_modificacion_contraseña')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
