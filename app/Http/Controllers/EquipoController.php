<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\equipo;
use Illuminate\Support\Facades\Auth;
use App\Models\Grupo;
use Illuminate\Validation\Rule;


class EquipoController extends Controller
{

    public function store(Request $request, $grupoId)
    {
        $request->validate([
            'nombre_empresa' => [
                'required',
                'string',
                'max:255',
                Rule::unique('equipos', 'nombre_empresa')->where(function ($query) {
                    $query->whereRaw('LOWER(nombre_empresa) = LOWER(?)', [request('nombre_empresa')]);
                }),
            ],
            'correo_empresa' => 'required|email|max:255',
            'link_drive' => 'required|url',
        ], [
            'nombre_empresa.unique' => 'El nombre de la empresa ya está registrado.',
        ]);

        // Crear el equipo
        $equipo = Equipo::create([
            'grupo_id' => $grupoId,
            'creador_id' => Auth::id(),
            'nombre_empresa' => $request->nombre_empresa,
            'correo_empresa' => $request->correo_empresa,
            'link_drive' => $request->link_drive,
        ]);
        $equipo->miembros()->attach(Auth::id(), ['rol' => 'scrum_master']);

        return redirect()->route('estudiante.inscripcion', $grupoId)->with('success', 'Equipo creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_empresa' => [
                'required',
                'string',
                'max:255',
                Rule::unique('equipos', 'nombre_empresa')->where(function ($query) {
                    $query->whereRaw('LOWER(nombre_empresa) = LOWER(?)', [request('nombre_empresa')]);
                }),
            ],
            'correo_empresa' => 'required|email|max:255',
            'link_drive' => 'required|url',
        ], [
            'nombre_empresa.unique' => 'El nombre de la empresa ya está registrado.',
        ]);

        $equipo = Equipo::findOrFail($id);
        $equipo->nombre_empresa = $request->nombre_empresa;
        $equipo->correo_empresa = $request->correo_empresa;
        $equipo->link_drive = $request->link_drive;
        $equipo->save();

        return redirect()->route('estudiante.inscripcion', $equipo->grupo_id)->with('success', 'Equipo actualizado exitosamente.');
    }


    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->route('estudiante.inscripcion', $equipo->grupo_id)->with('success', 'Equipo eliminado exitosamente.');
    }

    public function agregarMiembro(Request $request, $equipoId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $usuarioId = $request->input('usuario_id');
        $equipo->miembros()->attach($usuarioId);
        return redirect()->back()->with('success', 'Miembro añadido exitosamente.');
    }
    public function eliminarMiembro(Request $request, $equipoId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $usuarioId = $request->input('usuario_id');
        $equipo->miembros()->detach($usuarioId);
        return redirect()->back()->with('success', 'Miembro eliminado exitosamente.');
    }

    public function asignarRol(Request $request, $equipoId)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'rol' => 'required|in:scrum_master,product_owner,development',
        ]);

        $equipo = Equipo::findOrFail($equipoId);

        // Validar que el usuario autenticado sea Scrum Master
        $esScrumMaster = $equipo->miembros()
            ->wherePivot('usuario_id', Auth::id())
            ->wherePivot('rol', 'scrum_master')
            ->exists();

        if (!$esScrumMaster) {
            return redirect()->back()->withErrors(['error' => 'Solo el Scrum Master puede asignar roles.']);
        }

        $usuarioId = $request->input('usuario_id');
        $rol = $request->input('rol');

        // Validar que no se dupliquen los roles exclusivos
        if (in_array($rol, ['scrum_master', 'product_owner'])) {
            $existeRol = $equipo->miembros()->wherePivot('rol', $rol)->exists();
            if ($existeRol) {
                return redirect()->back()->withErrors(['error' => "El equipo ya tiene un $rol asignado."]);
            }
        }

        // Asignar el rol al miembro
        $equipo->miembros()->updateExistingPivot($usuarioId, ['rol' => $rol]);

        return redirect()->back()->with('success', "Rol $rol asignado exitosamente.");
    }
}
