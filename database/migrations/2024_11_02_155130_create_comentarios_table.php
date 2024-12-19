<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('contenido'); // Contenido del comentario
            $table->unsignedBigInteger('docente_id'); // Docente que hizo el comentario
            $table->unsignedBigInteger('sprint_id')->nullable(); // Opcional, si el comentario está relacionado con un sprint
            $table->unsignedBigInteger('subtarea_id')->nullable(); // Opcional, si el comentario está relacionado con una tarea
            $table->timestamps();
        
            // Llaves foráneas
            $table->foreign('docente_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            $table->foreign('subtarea_id')->references('id')->on('subtareas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
