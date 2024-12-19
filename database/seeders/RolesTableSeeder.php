<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;  // Importa el modelo Role
use Illuminate\Support\Facades\DB;


class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Rol::create(['name' => 'Administrador']);
        Rol::create(['name' => 'Docente']);
        Rol::create(['name' => 'Estudiante']);
    }
}

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->updateOrInsert(['name' => 'superadmin'], ['name' => 'superadmin']);
        DB::table('roles')->updateOrInsert(['name' => 'docente'], ['name' => 'docente']);
        DB::table('roles')->updateOrInsert(['name' => 'administrador'], ['name' => 'administrador']);
        DB::table('roles')->updateOrInsert(['name' => 'estudiante'], ['name' => 'estudiante']);
    }
}
