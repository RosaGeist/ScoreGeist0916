<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class PerfilController extends Controller
{
    public function mostrarMisDatos()
    {
        $usuario = Auth::user();
        return view('perfil', compact('usuario'));
    }
    public function updateProfile(Request $request)
    {
        $usuario = Auth::user(); // Obtener el usuario autenticado

        // Validar los campos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'phone' => 'nullable|string|max:15',
            'birthdate' => 'nullable|date',
        ]);

        // Actualizar los datos del usuario autenticado
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}
