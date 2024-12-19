<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{

    public function lista()
    {
        $usuarios = Usuario::all();
        $roles = Rol::all();
        return view('VistasAdmin.lista', compact('usuarios', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:15',
            'carrera' => 'nullable|string|in:ingenieria_informatica,ingenieria_en_sistemas',
            'codigoSIS' => 'nullable|string|max:11',
        ]);

        // Crear el usuario
        $usuario = Usuario::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'carrera' => $request->carrera,
            'codigoSIS' => $request->codigoSIS,
            'estado' => true,
        ]);

        // Intentar enviar el correo
        try {
            Mail::to($usuario->email)->send(new WelcomeEmail($usuario));
            \Log::info('Correo enviado a: ' . $usuario->email); // Log del envío
        } catch (\Exception $e) {
            \Log::error('Error al enviar correo: ' . $e->getMessage());
        }

        // Redirigir o devolver una respuesta
        return redirect()->route('listaRegistrados')->with('success', 'Usuario registrado con éxito!');
    }


    // Métodos de perfil
    public function showProfile()
    {
        $usuario = auth()->user();
        return view('perfil', compact('usuario'));
    }

    public function editProfile()
    {
        $usuario = auth()->user();
        return view('editarPerfil', compact('usuario'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . auth()->id(),
            'phone' => 'nullable|string|max:15',
            'carrera' => 'nullable|string|max:255',  // Nueva validación para carrera
            'codigoSIS' => 'nullable|string|max:255',  // Nueva validación para código SIS
        ]);

        $usuario = auth()->user();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->carrera = $request->carrera; // Guardar carrera
        $usuario->codigoSIS = $request->codigoSIS; // Guardar código SIS
        $usuario->save();

        return redirect()->route('perfil.show')->with('success', 'Perfil actualizado con éxito!');
    }


    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $id,
            'estado' => 'required|boolean',
            'carrera' => 'nullable|string|max:255',
            'codigoSIS' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        // Obtener el usuario a actualizar
        $usuario = Usuario::findOrFail($id);

        // Asignar los valores del formulario al modelo
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->estado = $request->estado;
        $usuario->phone = $request->phone;  // Guardar teléfono

        // Solo se actualizan los campos de carrera y código SIS si el rol es Estudiante
        if ($usuario->role->name == 'Estudiante') {
            $usuario->carrera = $request->carrera;
            $usuario->codigoSIS = $request->codigoSIS;
        }

        // Guardar los cambios en la base de datos
        $usuario->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('listaRegistrados')->with('success', 'Usuario actualizado con éxito!');
    }




    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('listaRegistrados')->with('success', 'Usuario eliminado con éxito!');
    }
}
