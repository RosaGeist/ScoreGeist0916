<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{


    public function showLinkRequestForm()
    {
        return view('recuperarContraseña'); // Vista para solicitar el restablecimiento de contraseña
    }

    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email|exists:usuarios,email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
}
}