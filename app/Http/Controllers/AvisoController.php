<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;
use App\Models\Aviso;

class AvisoController extends Controller
{

    public function index()
    {
        $docenteId = Auth::id();
        $grupos = Grupo::where('docente_id', $docenteId)->get();
        $avisos = Aviso::whereIn('grupo_id', $grupos->pluck('id'))->get();

        return view('VistasDocentes.avisos', compact('grupos', 'avisos'));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);

        $validatedData['docente_id'] = Auth::id();
        Aviso::create($validatedData);

        return redirect()->route('avisos.create')->with('success', 'Aviso publicado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $aviso = Aviso::findOrFail($id);
        $aviso->update($request->only(['grupo_id', 'titulo', 'contenido']));

        return redirect()->back()->with('success', 'Aviso actualizado exitosamente');
    }

    public function destroy($id)
    {
        $aviso = Aviso::findOrFail($id);
        $aviso->delete();

        return redirect()->back()->with('success', 'Aviso eliminado exitosamente');
    }
}
