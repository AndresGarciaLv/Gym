<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGymAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = Auth::user();
        $gym = $request->route('gym'); // Asume que la ruta tiene el parámetro 'gym'

        // Permitir acceso total a Super Administradores
        if ($authUser->hasRole('Super Administrador')) {
            return $next($request);
        }

        // Obtener los IDs de los gimnasios a los que pertenece el usuario autenticado
        $authUserGymIds = $authUser->gyms()->pluck('gyms.id');

        // Verificar si el usuario pertenece al gimnasio solicitado
        if ($authUserGymIds->contains($gym->id)) {
            return $next($request);
        }

        // Denegar acceso si no pertenece al gimnasio
        abort(403, 'No tienes permiso para acceder a este gimnasio.');
    }
}
