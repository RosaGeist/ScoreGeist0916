<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GrupoUsuario;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Str;

class GrupoController extends Controller
{

    public function index()
    {
        $grupos = Grupo::with('usuarios')->get();
        $usuariosPorGrupo = [];
        foreach ($grupos as $grupo) {

            $usuariosDisponibles = Usuario::whereHas('rol', function ($query) {
                $query->where('name', 'estudiante');
            })->whereNotIn('id', $grupo->usuarios->pluck('id'))->get();
            $usuariosPorGrupo[$grupo->id] = $usuariosDisponibles;
        }
        return view('VistasDocentes.grupo', compact('grupos', 'usuariosPorGrupo'));
    }



    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear un grupo.');
        }
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);
        $codigo = Str::random(6);
        Grupo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'codigo' => $codigo,
            'docente_id' => Auth::user()->id,
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para editar un grupo.');
        }
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'codigo' => 'required|string|max:6',
        ]);
        $grupo = Grupo::findOrFail($id);
        $grupo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'codigo' => $request->codigo,
            'docente_id' => Auth::user()->id,
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente.');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para eliminar un grupo.');
        }

        $grupo = Grupo::findOrFail($id);
        $grupo->delete();

        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado exitosamente.');
    }
    //agregar estudiantes en un grupo
    public function agregarEstudiante(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $existe = GrupoUsuario::where('usuario_id', $request->usuario_id)->exists();
        if ($existe) {
            return redirect()->back()->with('error', 'El estudiante ya está asignado a otro grupo.');
        }

        GrupoUsuario::create([
            'grupo_id' => $request->grupo_id,
            'usuario_id' => $request->usuario_id,
        ]);

        return redirect()->back()->with('success', 'Estudiante agregado exitosamente al grupo.');
    }

    public function eliminarEstudiante($grupoId, $usuarioId)
    {
        $grupo = Grupo::findOrFail($grupoId);
        $grupo->usuarios()->detach($usuarioId);

        return redirect()->back()->with('success', 'Estudiante eliminado del grupo exitosamente.');
    }



    // public function getGruposWithEquiposAndSprints()
    // {
    //     $docenteId = Auth::id();

    //     $grupos = Grupo::where('docente_id', $docenteId)
    //         ->with(['equipos.sprints', 'equipos.miembros'])
    //         ->get();

    //     return view('VistasDocentes.listaEquipos', compact('grupos'));
    // }
}
