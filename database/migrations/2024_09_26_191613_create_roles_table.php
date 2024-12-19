<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // ID del rol
            $table->string('name')->unique(); // Nombre del rol (único)
            $table->string('description')->nullable(); // Descripción del rol (opcional)
            $table->timestamps(); // Timestamps para creación y actualización
        });

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Administrador', 'description' => 'Usuario con acceso completo al sistema', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Estudiantes', 'description' => 'Usuario con acceso a las funcionalidades estudiantiles', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Docente', 'description' => 'Usuario que supervisa y evalúa a los estudiantes', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
