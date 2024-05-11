<?php

namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $role = optional($user->roles->first())->name;
        switch ($role) {
            case 'Super Administrador':
                return redirect()->route('Dashboard-Adm');
            case 'Administrador':
                return redirect()->route('Dashboard-Adm');
            case 'Staff':
                $adviserId = $user->slug;
                return redirect()->route('Dashboard-Adm');
            default:
                return redirect('/perfil');
        }
    }
}
