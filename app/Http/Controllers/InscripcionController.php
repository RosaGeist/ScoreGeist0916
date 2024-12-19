<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function inscripcion()
    {
        // Obtener todos los grupos
        $grupos = Grupo::all();
        
        // Obtener todos los usuarios sin equipo
        $usuariosSinEquipo = collect();
        foreach ($grupos as $grupo) {
            foreach ($grupo->usuarios as $usuario) {
                if ($usuario->equipos->isEmpty()) {
                    $usuariosSinEquipo->push($usuario); // Agregar solo los usuarios sin equipo
                }
            }
        }
    
        $usuario = Auth::user(); // Obtener el usuario autenticado
        return view('VistasEstudiantes.inscripcion', compact('grupos', 'usuario', 'usuariosSinEquipo')); // Pasar los datos a la vista
    }
    

    public function registrar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);

        $grupo = Grupo::where('codigo', $request->codigo)->first();

        if (!$grupo) {
            return redirect()->back()->with('error', 'Código de grupo inválido.');
        }
        if (Auth::user()->gruposAsignados()->where('grupo_id', $grupo->id)->exists()) {
            return redirect()->back()->with('error', 'Ya estás registrado en este grupo.');
        }
        Auth::user()->gruposAsignados()->attach($grupo->id);

        return redirect()->route('estudiante.dashboard')->with('success', 'Te has registrado exitosamente en el grupo.');
    }
}
