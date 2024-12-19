<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('reset')->with(['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $user = Usuario::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // Opcionalmente, puedes cerrar la sesión del usuario y redirigirlo a la página de inicio
        Auth::logout();

        return redirect()->route('login')->with('status', 'Su contraseña ha sido restablecida. Puede iniciar sesión.');
    }
}
