<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckUserEditPermissions
{
    public function handle(Request $request, Closure $next)
    {
        $authUser = Auth::user();
        $userIdToEdit = $request->route('user'); // Asume que la ruta tiene el parámetro 'user'
        $userToEdit = User::findOrFail($userIdToEdit);

        // Permitir acceso total a Super Administradores
        if ($authUser->hasRole('Super Administrador')) {
            return $next($request);
        }

        // Restringir acceso si el usuario a editar es un Super Administrador
        if ($userToEdit->hasRole('Super Administrador')) {
            abort(403, 'No tienes permiso para editar este usuario.');
        }

        // Obtener los IDs de los gimnasios a los que pertenece el usuario autenticado y el usuario a editar
        $authUserGymIds = $authUser->gyms()->pluck('gyms.id');
        $userToEditGymIds = $userToEdit->gyms()->pluck('gyms.id');

        // Verifica si el usuario autenticado es un Administrador y pertenece al mismo gimnasio que el usuario a editar
        if ($authUser->hasRole('Administrador') && $authUserGymIds->intersect($userToEditGymIds)->isNotEmpty()) {
            return $next($request);
        }

        // Verifica si el usuario autenticado es un Staff y cumple con las restricciones adicionales
        if ($authUser->hasRole('Staff')) {

            if ($authUser->id === $userToEdit->id) {
                return $next($request);
            }

            // Verificar si el usuario a editar tiene rol de Administrador o Super Administrador
            if ($userToEdit->hasRole('Administrador') || $userToEdit->hasRole('Super Administrador') || $userToEdit->hasRole('Staff')) {
                abort(403, 'No tienes permiso para editar este usuario.');
            }

            // Verificar si el usuario a editar tiene rol de Staff o Cliente
            if ($userToEdit->hasAnyRole(['Cliente']) && $authUserGymIds->intersect($userToEditGymIds)->isNotEmpty()) {
                return $next($request);
            }

            abort(403, 'No tienes permiso para editar este usuario.');
        }

        abort(403, 'No tienes permiso para editar este usuario.');
    }
}
