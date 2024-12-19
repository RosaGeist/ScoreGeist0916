<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && in_array(Auth::user()->role_id, $role)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'No tienes acceso a esta sección.');
    }
}