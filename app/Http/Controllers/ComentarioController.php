<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function storeSprintComentario(Request $request, $sprintId)
    {
        $request->validate(['contenido' => 'required|string']);

        Comentario::create([
            'contenido' => $request->contenido,
            'docente_id' => auth()->id(),
            'sprint_id' => $sprintId,
        ]);

        return redirect()->back()->with('success', 'Comentario agregado al sprint.');
    }

    public function destroySprintComentario($comentarioId)
    {
        $comentario = Comentario::where('id', $comentarioId)->whereNotNull('sprint_id')->firstOrFail();

        // Elimina el comentario
        $comentario->delete();

        return redirect()->back()->with('success', 'Comentario del sprint eliminado correctamente.');
    }

    public function storeSubtareaComentario(Request $request, $subtareaId)
    {
        $request->validate(['contenido' => 'required|string']);

        // Crea un comentario asociado a la subtarea
        Comentario::create([
            'contenido' => $request->contenido,
            'docente_id' => auth()->id(),
            'subtarea_id' => $subtareaId,  // Asociamos el comentario a la subtarea
        ]);

        return redirect()->back()->with('success', 'Comentario agregado a la subtarea.');
    }

    public function destroySubtareaComentario($comentarioId)
    {
        // Encuentra el comentario y asegúrate que pertenezca a una subtarea
        $comentario = Comentario::where('id', $comentarioId)->whereNotNull('subtarea_id')->firstOrFail();

        // Elimina el comentario
        $comentario->delete();

        return redirect()->back()->with('success', 'Comentario de la subtarea eliminado correctamente.');
    }
}
