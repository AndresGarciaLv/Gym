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

        // Verificar si el usuario está activo
        if (!$user->isActive) {
            Auth::logout();
            flash()->error('Su cuenta ha sido Desactivada. Por favor, contácte al Administrador del Sistema');
            return redirect()->route('login');
        }

        // Asumiendo que el modelo de usuario tiene una relación 'roles' que devuelve una colección
        $role = optional($user->roles->first())->name; // Usa 'optional' para manejar casos donde no hay roles

        flash()->success('Bienvenido, ' . $user->name . '!');

        // Redirigir según el rol del usuarioDashboard-SupAdm
        switch ($role) {
            case 'Super Administrador':
                return redirect()->route('Dashboard-SupAdm');
            case 'Administrador':
                return redirect()->route('Dashboard-Adm');
            case 'Staff':
                return redirect()->route('Dashboard-St');
            case 'Checador':

                    // Obtener el gimnasio al que pertenece el usuario con rol de Checador
                    $gym = $user->gyms->first(); // Suponiendo que el usuario solo pertenece a un gimnasio

                    if ($gym) {
                        return redirect()->route('admin.gym-log.index', ['gym' => $gym->id]);
                    } else {
                        Auth::logout();
                        flash()->error('No se ha encontrado un gimnasio asociado. Por favor, contácte al Administrador del Sistema');
                        return redirect()->route('login');
                    }
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

        flash()->success('Sesión cerrada correctamente.');

        return redirect('/');
    }
}
