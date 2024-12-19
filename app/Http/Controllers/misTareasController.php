<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tarea;
use App\Models\Sprint;

class misTareasController extends Controller
{
    public function misTareasPorSprint()
    {
        $usuario = Auth::user();

        // Obtiene las tareas del usuario, agrupadas por sprint
        $tareasPorSprint = Tarea::where('usuario_id', $usuario->id)
            ->with('sprint')
            ->get()
            ->groupBy('sprint_id');

        return view('VistasEstudiantes.misTareas', compact('tareasPorSprint'));
    }
    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'estado' => 'required|in:Pendiente,En Proceso,Completado,Bloqueado,Revisar',
        ]);

        $tarea = Tarea::findOrFail($id);
        $tarea->update($validatedData);

        return redirect()->back()->with('success', 'Estado de la tarea actualizado exitosamente.');
    }
    
}
