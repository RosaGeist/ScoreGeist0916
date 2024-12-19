<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('creador_id'); // Agregamos el campo creador_id
            $table->string('nombre_empresa');
            $table->string('correo_empresa');
            $table->string('link_drive');
            $table->integer('min_personas')->default(3);
            $table->integer('max_personas')->default(5);
            $table->timestamps();

            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->foreign('creador_id')->references('id')->on('usuarios')->onDelete('cascade'); // Referencia a la tabla de usuarios
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}
