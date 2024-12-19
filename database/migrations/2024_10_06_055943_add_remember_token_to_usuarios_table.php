<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRememberTokenToUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->string('remember_token')->nullable()->after('password'); // Asegúrate de que se agregue después de 'password'
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->dropColumn('remember_token');
    });
}

}
