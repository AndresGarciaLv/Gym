<?php
// Middleware para RESTRINGIR EL ACCESO AL ASIGNAR MEMBRESÍAS A LOS ADMINISTRADORES Y STAFF.

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckGymMembership
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $gymId = $request->route('gym');

        // Permitir acceso total a Super Administradores
        if ($user->hasRole('Super Administrador')) {
            return $next($request);
        }

        // Verifica si el usuario tiene el permiso 'admin.user-memberships.create'
        if ($user->can('admin.user-memberships.create')) {
            // Verifica si el usuario pertenece al gimnasio
            if ($user->gyms()->where('id_gym', $gymId)->exists()) { // Asegúrate de usar el nombre correcto de la columna
                return $next($request);
            } else {
                abort(403, 'No tienes permiso para acceder a este gimnasio.');
            }
        }

        abort(403, 'No tienes permiso para realizar esta acción.');
    }
}
