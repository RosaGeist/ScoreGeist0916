<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // ID del usuario
            $table->string('name'); // Nombre
            $table->string('email')->unique(); // Correo electrónico (único)
            $table->string('password'); // Contraseña
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // ID del rol
            $table->string('phone', 15)->nullable(); // Teléfono (opcional)
            $table->boolean('estado')->default(true); // Estado activo/inactivo
            $table->string('carrera', 255)->nullable(); // Carrera (opcional)
            $table->string('codigoSIS', 11)->nullable(); // Código SIS (opcional)
            $table->timestamps(); // Fechas de creación y actualización
        });

        // Insertar usuario administrador predeterminado
        DB::table('usuarios')->insert([
            [
                'id' => 1, // Asegúrate de usar un ID fijo para el administrador
                'name' => 'Administrador del Sistema',
                'email' => 'admin@dominio.com',
                'password' => bcrypt('admin123'), // Encripta la contraseña
                'role_id' => 1, // ID del rol 'Administrador' (asegúrate de que exista)
                'phone' => '123456789',
                'estado' => true,
                'carrera' => null,
                'codigoSIS' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
