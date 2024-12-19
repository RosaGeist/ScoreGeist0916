<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Usuario;

class LoginController extends Controller
{
    // Muestra el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('login'); // Asegúrate de tener una vista llamada 'login.blade.php'
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = Usuario::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'El email no está registrado.']);
    }

    if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return back()->withErrors(['password' => 'La contraseña es incorrecta.']);
    }


    $user = Auth::user();

    if ($user->rol && $user->rol->name === 'Administrador') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->rol && $user->rol->name === 'Estudiante') {
        return redirect()->route('estudiante.dashboard');
    } elseif ($user->rol && $user->rol->name === 'Docente') {
        return redirect()->route('docente.dashboard');
    }


    Auth::logout(); 
    return redirect('/')->withErrors(['rol' => 'Rol no permitido.']);
}


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/'); // Redirige a la página principal después de cerrar sesión
    }
}
