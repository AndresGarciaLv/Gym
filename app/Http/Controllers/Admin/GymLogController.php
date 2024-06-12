<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GymLog;
use App\Models\User;
use App\Models\UserMembership;
use Carbon\Carbon;

class GymLogController extends Controller
{
    public function index()
    {
        return view('gym-logs.index');
    }

    public function logAction(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|exists:users,code',
            'id_gym' => 'required|exists:gyms,id',
        ]);

        $user = User::where('code', $validated['code'])->first();
        $lastLog = GymLog::where('id_user', $user->id)->latest()->first();

        if ($lastLog && $lastLog->action === 'entry') {
            return $this->logExit($validated, $user);
        }

        return $this->logEntry($validated, $user);
    }

    private function logEntry($validated, $user)
    {
        $membership = $this->checkMembershipStatus($user->id);

        if ($membership) {
            $status = $this->getMembershipStatus($membership);
            $daysRemaining = $this->getDaysRemaining($membership);

            GymLog::create([
                'id_user' => $user->id,
                'id_gym' => $validated['id_gym'],
                'action' => 'entry',
                'created_at' => Carbon::now(),
            ]);

            $message = $this->generateMessage($status, $daysRemaining);
            return redirect()->back()->with('message', $message);
        }

        return redirect()->back()->withErrors(['code' => 'Membresía no válida o expirada.']);
    }

    private function logExit($validated, $user)
    {
        GymLog::create([
            'id_user' => $user->id,
            'id_gym' => $validated['id_gym'],
            'action' => 'exit',
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('message', 'Salida registrada exitosamente.');
    }

    private function checkMembershipStatus($userId)
    {
        $currentDate = Carbon::now();
        return UserMembership::where('id_user', $userId)
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->where('isActive', true)
            ->first();
    }

    private function getMembershipStatus($membership)
    {
        $now = Carbon::now()->startOfDay();
        $end_date = Carbon::parse($membership->end_date)->startOfDay();
        $days_remaining = $now->diffInDays($end_date, false);

        if ($now->isSameDay($end_date)) {
            return 'Vence Hoy';
        } elseif ($days_remaining > 4) {
            return 'Vigente';
        } elseif ($days_remaining >= 1 && $days_remaining <= 4) {
            return 'Por Vencer';
        } else {
            return 'Vencido';
        }
    }

    private function getDaysRemaining($membership)
    {
        $now = Carbon::now()->startOfDay();
        $end_date = Carbon::parse($membership->end_date)->startOfDay();
        return $now->diffInDays($end_date, false);
    }

    private function generateMessage($status, $daysRemaining)
    {
        switch ($status) {
            case 'Vigente':
                return "Bienvenido, disfruta tu visita. Te quedan $daysRemaining días.";
            case 'Por Vencer':
                return "Te quedan $daysRemaining días. Te invitamos a renovar tu membresía en recepción.";
            case 'Vence Hoy':
                return "Hoy vence tu membresía. Pasa a recepción a renovar tu membresía.";
            case 'Vencido':
                return "Tu membresía ya venció. Pasa a recepción a renovar tu membresía.";
            default:
                return "Estado de membresía desconocido.";
        }
    }
}
