<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesPorParesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones_por_pares', function (Blueprint $table) {
            $table->id(); // ID de la evaluación
            $table->foreignId('usuario_id')->constrained('usuarios'); // ID del usuario que evalúa
            $table->foreignId('evaluado_id')->constrained('usuarios'); // ID del usuario evaluado
            $table->foreignId('sprint_id')->constrained('sprints'); // ID del sprint
            $table->foreignId('pregunta_id')->constrained('preguntas'); // ID de la pregunta
            $table->string('respuesta'); // Respuesta (puede ser texto o número)
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones_por_pares');
    }
}
