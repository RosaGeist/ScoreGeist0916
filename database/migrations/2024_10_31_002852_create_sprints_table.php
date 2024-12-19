<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSprintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); 
            $table->text('objetivo')->nullable(); 
            $table->date('fecha_inicio');
            $table->date('fecha_fin'); 
            $table->foreignId('proyecto_id')
                ->constrained('proyectos') 
                ->onDelete('cascade');
            $table->enum('estado', ['Pendiente', 'En Proceso', 'Completado'])->default('Pendiente'); // Agregar el estado
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
        Schema::dropIfExists('sprints');
    }
}
