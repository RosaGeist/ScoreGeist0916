<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\HistoriaUsuario;
use App\Models\Sprint;

class HistoriaUsuarioController extends Controller
{

    public function show($id)
{
    // Encuentra el sprint con las relaciones necesarias, incluyendo los comentarios
    $sprint = Sprint::with([
        'proyecto.equipo.miembros',  // Miembros del equipo
        'historias.subtareas',       // Subtareas
        'comentarios',               // Carga los comentarios
    ])->findOrFail($id);

    // Obtén los miembros del equipo asociado al proyecto del sprint
    $miembros = $sprint->proyecto->equipo->miembros;

    // Pasa los datos a la vista
    return view('VistasEstudiantes.sprint-detalle', compact('sprint', 'miembros'));
}


    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'estado' => 'required|in:Pendiente,En progreso,Completada',
            'criterios_aceptacion' => 'required|string',
            'sprints_id' => 'required|exists:sprints,id', // Verifica que el sprint exista
        ]);

        // Crear la historia de usuario
        HistoriaUsuario::create($validated);

        // Redirigir al sprint con mensaje de éxito
        return redirect()->route('historias.show', $request->sprints_id)->with('success', 'Historia de usuario creada correctamente');
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'prioridad' => 'required|string|in:Alta,Media,Baja',
        'estado' => 'required|string|in:pendiente,en progreso,completado',
    ]);

    $historia = HistoriaUsuario::findOrFail($id);
    $historia->update($validated);

    return back()->with('success', 'Historia actualizada exitosamente.');
}


public function destroy($id)
{
    $historia = HistoriaUsuario::findOrFail($id);
    $historia->delete();

    return back()->with('success', 'Historia eliminada correctamente.');
}

}
