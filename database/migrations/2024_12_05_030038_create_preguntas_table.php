<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id(); 
            $table->text('texto'); 
            $table->enum('tipo', ['f/v', 'escala_1_5', 'respuesta_corta']); 
            $table->enum('evaluacion', ['autoevaluacion', 'cruzada', 'porpares']);
            $table->enum('estado', ['activo', 'inactivo']);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas');
    }
}
