<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_id')->constrained()->onDelete('cascade'); // Relaciona con el sprint
            $table->foreignId('usuario_id')->constrained()->onDelete('cascade'); // Relaciona con el usuario
            $table->foreignId('pregunta_id')->constrained()->onDelete('cascade'); // Relaciona con la pregunta
            $table->text('respuesta'); // La respuesta dada por el usuario
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
        Schema::dropIfExists('respuestas');
    }
}
