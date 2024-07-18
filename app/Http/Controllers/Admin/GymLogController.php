<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GymLog;
use App\Models\User;
use App\Models\UserMembership;
use App\Models\Gym;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class GymLogController extends Controller
{
    public function index(Gym $gym)
    {
        return view('admin.gym-logs.index', compact('gym'));
    }

    public function logAction(Request $request, Gym $gym)
    {
        // Validación con mensaje de error personalizado
        $rules = [
            'code' => 'required|exists:users,code',
            'id_gym' => 'required|exists:gyms,id',
        ];

        $messages = [
            'code.exists' => 'El código no existe en nuestro sistema.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $user = User::where('code', $validated['code'])->first();
        $lastLog = GymLog::where('id_user', $user->id)->latest()->first();
        $membership = $this->checkMembershipStatus($user->id, $gym->id);

        if ($membership) {
            $membershipStatus = $this->getMembershipStatus($membership);
            if ($membershipStatus == 'Vencido') {
                return redirect()->back()->with([
                    'status' => 'Vencido',
                    'message' => 'Tu membresía está vencida. Pasa a recepción a renovarla.',
                    'membership' => $membership,
                    'user' => $user,
                    'currentTime' => Carbon::now()->format('H:i:s'),
                ]);
            }
        } else {
            return redirect()->back()->withErrors(['code' => 'No cuenta con una membresía activa para este gimnasio.']);
        }

        if ($lastLog && $lastLog->action === 'entry') {
            return $this->logExit($validated, $user, $membership);
        }

        return $this->logEntry($validated, $user, $membership);
    }




    private function logEntry($validated, $user, $membership)
    {
        if ($membership) {
            $status = $this->getMembershipStatus($membership);
            $daysRemaining = $this->getDaysRemaining($membership);
            $currentTime = Carbon::now()->format('H:i:s'); // Formato de hora

            GymLog::create([
                'id_user' => $user->id,
                'id_gym' => $validated['id_gym'],
                'action' => 'entry',
                'created_at' => Carbon::now(),
            ]);

            $message = $this->generateMessage($status, $daysRemaining);
            return redirect()->back()->with([
                'message' => $message,
                'membership' => $membership,
                'user' => $user,
                'status' => $status,
                'action' => 'entry',
                'currentTime' => $currentTime, // Guardar la hora en la sesión
            ]);
        }

        return redirect()->back()->withErrors(['code' => 'Membresía no válida o expirada.']);
    }

    private function logExit($validated, $user, $membership)
    {
        $currentTime = Carbon::now()->format('H:i:s'); // Formato de hora

        GymLog::create([
            'id_user' => $user->id,
            'id_gym' => $validated['id_gym'],
            'action' => 'exit',
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with([
            'message' => 'Salida registrada exitosamente. ¡Nos Vemos Pronto!',
            'membership' => $membership,
            'user' => $user,
            'status' => 'exit',
            'action' => 'exit',
            'currentTime' => $currentTime, // Guardar la hora en la sesión
        ]);
    }

    private function checkMembershipStatus($userId, $gymId)
    {
        $currentDate = Carbon::now();
        return UserMembership::where('id_user', $userId)
            ->where('id_gym', $gymId)
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
                return "Te quedan $daysRemaining días.";
            case 'Por Vencer':
                return "Te quedan $daysRemaining días.";
            case 'Vence Hoy':
                return "Hoy vence tu membresía.";
            case 'Vencido':
                return "Tu membresía ya venció. Pasa a recepción a renovar tu membresía.";
            default:
                return "Estado de membresía desconocido.";
        }
    }
}
