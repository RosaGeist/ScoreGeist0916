<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('grupos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100);
        $table->text('descripcion')->nullable();
        $table->string('codigo', 6)->unique(); // Se asegura que el código sea único
        $table->unsignedBigInteger('docente_id');
        $table->timestamps();

        // Definir la clave foránea
        $table->foreign('docente_id')
            ->references('id')
            ->on('usuarios')
            ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupos');
    }
}
