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

        // Verifica si el usuario autenticado es un Administrador y pertenece al mismo gimnasio que el usuario a editar
        $authUserGymIds = $authUser->gyms()->pluck('gyms.id');
        $userToEditGymIds = $userToEdit->gyms()->pluck('gyms.id');

        if ($authUser->hasRole('Administrador') && $authUserGymIds->intersect($userToEditGymIds)->isNotEmpty()) {
            return $next($request);
        }

        abort(403, 'No tienes permiso para editar este usuario.');
    }
}
