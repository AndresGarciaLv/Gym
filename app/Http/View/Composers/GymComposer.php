<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Gym;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class GymComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = Auth::user();

        if ($user) {
            if ($user->hasRole('Administrador')) {
                $allGyms = $user->gyms;
            } elseif ($user->hasRole('Super Administrador')) {
                $allGyms = Gym::all();
            } else {
                $allGyms = collect(); // Colección vacía si no tiene acceso
            }
        } else {
            $allGyms = collect(); // Colección vacía si no hay usuario autenticado
        }

        $view->with('allGyms', $allGyms);
    }
}
