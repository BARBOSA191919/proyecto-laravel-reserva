<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Symfony\Component\HttpFoundation\Response;

class CustomRoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response // Añade el parámetro $role
    {
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        return redirect('/')->with('error', 'No tienes permiso para acceder a esta sección.');
        // O podrías usar:
        // abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}