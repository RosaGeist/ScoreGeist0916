<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriaUsuario;
use App\Models\Subtarea;

class SubtareaController extends Controller
{
    public function store(Request $request, $historiaId)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string|in:Pendiente,En Progreso,Completada',
            'miembro_asignado' => 'nullable|integer',
        ]);

        $historia = HistoriaUsuario::findOrFail($historiaId);
        $equipo = $historia->sprint->proyecto->equipo;  
        $miembros = $equipo->usuarios; 
        $subtarea = new Subtarea($validated);
        $subtarea->historia_usuario_id = $historia->id;
        $subtarea->miembro_asignado = $request->miembro_asignado;
        $subtarea->save();
        return back()->with('success', 'Subtarea agregada exitosamente.');

    }

    public function update(Request $request, $id)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:Pendiente,En Progreso,Completada',
            'miembro_asignado' => 'nullable|exists:usuarios,id', // Cambiar 'users' por 'usuarios'
        ]);

        // Encontrar la subtarea
        $subtarea = Subtarea::findOrFail($id);

        // Obtener la historia de usuario asociada para redirigir correctamente
        $historiaUsuario = $subtarea->historiaUsuario;

        // Actualizar los valores
        $subtarea->titulo = $validatedData['titulo'];
        $subtarea->descripcion = $validatedData['descripcion'];
        $subtarea->estado = $validatedData['estado'];
        $subtarea->miembro_asignado = $validatedData['miembro_asignado'] ?? null; // Si no hay miembro asignado, dejar en null
        $subtarea->save();

        // Regresar a la misma página con el mensaje de éxito
        return back()->with([
            'success' => 'Subtarea actualizada correctamente.',
            'historiaUsuario' => $historiaUsuario,  // Pasar los datos de la historia de usuario
            'sprint' => $historiaUsuario->sprint   // Pasar los datos del sprint
        ]);
    }

    public function destroy($id)
{
    // Encontrar la subtarea
    $subtarea = Subtarea::findOrFail($id);

    // Eliminar la subtarea
    $subtarea->delete();

    // Redirigir a la página anterior con un mensaje de éxito
    return back()->with('success', 'Subtarea eliminada correctamente.');
}

}
