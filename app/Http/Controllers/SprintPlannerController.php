<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;

class SprintPlannerController extends Controller
{

    public function index()
    {
        $usuario = auth()->user();
    
        // Recuperar equipos con sus proyectos y sprints
        $equipos = $usuario->equipos()
            ->with('proyectos.sprints') // Cargar proyectos y sus sprints
            ->get();
    
        // Recuperar todos los proyectos asociados (por si necesitas usarlos separados)
        $proyectos = $equipos->pluck('proyectos')->flatten();
    
        return view('VistasEstudiantes.sprint-planner', compact('equipos', 'proyectos'));
    }
    


    public function store(Request $request)
    {
        $validated = $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id',
            'nombre' => 'required|string|max:255',
            'objetivo' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Sprint::create($validated);
        return redirect()->route('sprint-planner')->with('success', 'Sprint creado exitosamente.');
    }



    public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'objetivo' => 'required|string',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date',
        'estado' => 'required|string|in:Pendiente,En Proceso,Completado', // Validación para el estado
    ]);

    $sprint = Sprint::findOrFail($id);
    $sprint->update([
        'nombre' => $request->nombre,
        'objetivo' => $request->objetivo,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'estado' => $request->estado, // Actualización del estado
    ]);

    return redirect()->back()->with('success', 'Sprint actualizado correctamente.');
}

    public function destroy($id)
    {
        $sprint = Sprint::findOrFail($id);
        $sprint->delete();
        return redirect()->back()->with('success', 'Sprint eliminado con éxito.');
    }
}
