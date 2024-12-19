<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Equipo;
use App\Models\Grupo;

use Illuminate\Http\Request;

class ProyectosController extends Controller
{

    public function mostrarProyectos($equipoId)
    {
        // Obtener el equipo con sus proyectos y su grupo asociado
        $equipo = Equipo::with(['proyectos', 'grupo'])->findOrFail($equipoId);

        // Pasar tanto el equipo como el grupo a la vista
        return view('VistasEstudiantes.proyecto', compact('equipo'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'objetivos' => 'required|string',
            'duracion_inicio' => 'required|date',
            'duracion_fin' => 'required|date',
            'estado' => 'required|in:planeado,en progreso,finalizado',
            'equipo_id' => 'required|exists:equipos,id',
        ]);

        // Crear el proyecto con el equipo preseleccionado
        Proyecto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'objetivos' => $request->objetivos,
            'duracion_inicio' => $request->duracion_inicio,
            'duracion_fin' => $request->duracion_fin,
            'estado' => $request->estado,
            'equipo_id' => $request->equipo_id,
            'creador_id' => auth()->user()->id, // Asumiendo que el creador es el usuario autenticado
        ]);

        // Redirigir a la lista de proyectos del equipo recién creado
        return redirect()->route('equipos.proyectos', ['equipo' => $request->equipo_id])->with('success', 'Proyecto creado exitosamente');
    }


    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'objetivos' => 'required|string',
            'estado' => 'required|string|in:planeado,en progreso,finalizado',
        ]);

        // Obtener el proyecto por su ID
        $proyecto = Proyecto::findOrFail($id);

        // Actualizar el proyecto con los nuevos datos (sin modificar las fechas de inicio y fin)
        $proyecto->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'objetivos' => $validated['objetivos'],
            'estado' => $validated['estado'],
        ]);

        // Redirigir a la lista de proyectos con un mensaje de éxito
        return redirect()->route('equipos.proyectos', ['equipo' => $proyecto->equipo_id])->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy($id)
    {

        $proyecto = Proyecto::findOrFail($id);
        $equipoId = $proyecto->equipo_id;
        $proyecto->delete();
        return redirect()->route('equipos.proyectos', ['equipo' => $equipoId])->with('success', 'Proyecto eliminado exitosamente.');
    }


    public function planificacion($id)
{
    // Obtener el proyecto por su ID
    $proyecto = Proyecto::findOrFail($id);

    // Obtener los sprints del proyecto
    $sprints = $proyecto->sprints; 

    // Obtener el equipo asociado al proyecto
    $equipo = $proyecto->equipo;  // Asegúrate de tener esta relación en el modelo Proyecto

    // Pasar el proyecto, los sprints y el equipo a la vista
    return view('VistasEstudiantes.planificacion', compact('proyecto', 'sprints', 'equipo'));
}

}
