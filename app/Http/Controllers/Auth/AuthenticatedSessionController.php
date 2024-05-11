<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
    
        // Obtener el usuario autenticado
        $user = Auth::user();
        // Asumiendo que el modelo de usuario tiene una relación 'roles' que devuelve una colección
        $role = optional($user->roles->first())->name; // Usa 'optional' para manejar casos donde no hay roles
    
        // Redirigir según el rol del usuario
        switch ($role) {
            case 'Administrador':
                return redirect()->route('Dashboard-Adm');
            case 'Staff':
                return redirect()->route('Dashboard-St');
            default:
                return redirect('/'); // Redirige a una ruta predeterminada si no tiene roles específicos
        }
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
