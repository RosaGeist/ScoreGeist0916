<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('proyectos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->text('objetivos')->nullable();
        $table->date('duracion_inicio');
        $table->date('duracion_fin');
        $table->enum('estado', ['planeado', 'en progreso', 'finalizado'])->default('planeado');
        $table->unsignedBigInteger('equipo_id'); // Relación con equipo
        $table->unsignedBigInteger('creador_id'); // Relación con usuario creador
        $table->timestamps();

        // Llave foránea para equipos
        $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');

        // Llave foránea para usuario creador
        $table->foreign('creador_id')->references('id')->on('usuarios')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
