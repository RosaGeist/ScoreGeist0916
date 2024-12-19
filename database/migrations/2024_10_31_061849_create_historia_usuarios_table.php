<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historias_de_usuario', function (Blueprint $table) {
            $table->id();  // id auto incremental
            $table->string('titulo');  // Título de la historia de usuario
            $table->text('descripcion');  // Descripción de la historia
            $table->foreignId('sprints_id')->constrained('sprints')->onDelete('cascade');  
            $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');  
            $table->enum('estado', ['pendiente', 'en progreso', 'completada'])->default('pendiente');  // Estado de la historia
            $table->text('criterios_aceptacion')->nullable();  // Criterios de aceptación de la historia
            $table->timestamps();  // created_at y updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historia_usuarios');
    }
}
