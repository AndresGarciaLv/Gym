<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckGymOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $gymId = $request->route('gym');

        // Permitir acceso total a Super Administradores
        if ($user->hasRole('Super Administrador')) {
            return $next($request);
        }

        // Verifica si el usuario tiene el permiso y pertenece al gimnasio
        if ($user->can('admin.gyms.edit') || $user->can('admin.gyms.update')) {
            if ($user->gyms()->where('id_gym', $gymId)->exists()) {
                return $next($request);
            } else {
                abort(403, 'No tienes permiso para editar este gimnasio.');
            }
        }

        abort(403, 'No tienes permiso para realizar esta acción.');
    }
}
