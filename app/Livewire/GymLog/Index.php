<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMembership;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GymLogController extends Controller
{
    public function index()
    {
        return view('gym-logs.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:users,code',
        ]);

        $code = $request->input('code');
        $user = User::where('code', $code)->with('memberships')->first();

        if ($user) {
            $membership = $user->memberships()
                ->where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->where('isActive', true)
                ->first();

            if ($membership) {
                $status = $membership->status;
                $daysRemaining = Carbon::now()->startOfDay()->diffInDays(Carbon::parse($membership->end_date)->startOfDay(), false);

                switch ($status) {
                    case 'Vigente':
                        $message = "Bienvenido, disfruta tu visita. Te quedan {$daysRemaining} días.";
                        break;
                    case 'Por Vencer':
                        $message = "Te quedan {$daysRemaining} días. Te invitamos a renovar tu membresía en recepción.";
                        break;
                    case 'Vence Hoy':
                        $message = "Hoy vence tu membresía. Pasa a recepción a renovar tu membresía.";
                        break;
                    case 'Vencido':
                        $message = "Tu membresía ya venció. Pasa a recepción a renovar tu membresía.";
                        break;
                    default:
                        $message = "Estado de membresía desconocido.";
                        break;
                }
            } else {
                $status = 'Vencido';
                $daysRemaining = 0;
                $message = "Tu membresía ya venció. Pasa a recepción a renovar tu membresía.";
            }

            return view('gym-logs.index', compact('user', 'message', 'status', 'daysRemaining'));
        } else {
            return view('gym-logs.index')->withErrors(['code' => 'Usuario no encontrado.']);
        }
    }
}
