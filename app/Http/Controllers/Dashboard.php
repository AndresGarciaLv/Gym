<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gym;
use App\Models\Membership;
use App\Models\UserMembership;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function superAdmin()
    {
        // Obtener todos los usuarios
        $users = User::with('roles')->get();
        $totalUsers = $users->count(); // Obtener el total de usuarios

        // Obtener el total de gimnasios
        $totalGyms = Gym::count();

        // Obtener el total de membresías
        $totalMemberships = Membership::count();

        // Obtener el total de membresías activas
        $activeMemberships = UserMembership::where('isActive', true)->count();

        return view('home.supadm-dash', compact('users', 'totalUsers', 'totalGyms', 'totalMemberships', 'activeMemberships'));
    }
}
