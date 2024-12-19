<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Título de la subtarea
            $table->text('descripcion'); // Descripción detallada de la subtarea
            $table->enum('estado', ['Pendiente', 'En Progreso', 'Completada'])->default('Pendiente'); 
            $table->unsignedBigInteger('historia_usuario_id'); 
            $table->unsignedBigInteger('miembro_asignado')->nullable();
            $table->timestamps();

            $table->foreign('historia_usuario_id')->references('id')->on('historias_de_usuario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtareas');
    }
}
