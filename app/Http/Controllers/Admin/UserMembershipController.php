<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DurationType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gym;
use App\Models\Membership;
use App\Models\UserMembership;
use Carbon\Carbon;

class UserMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    public function userMembershipsHistory($userId)
{
    $user = User::with('roles')->findOrFail($userId);
    $activeMembership = UserMembership::with(['gym', 'membership'])
        ->where('id_user', $userId)
        ->where('isActive', true)
        ->first();
    $inactiveMemberships = UserMembership::with(['gym', 'membership'])
        ->where('id_user', $userId)
        ->where('isActive', false)
        ->orderBy('end_date', 'desc')
        ->get();
        $gymId = $activeMembership ? $activeMembership->id_gym : ($inactiveMemberships->first() ? $inactiveMemberships->first()->id_gym : null);

        return view('admin.user-memberships.history', compact('user', 'activeMembership', 'inactiveMemberships', 'gymId'));
}


    public function membershipsByGym($id)
    {
        $gym = Gym::findOrFail($id);
        $userMemberships = UserMembership::with(['user.roles', 'gym', 'membership'])
            ->where('id_gym', $id)
            ->paginate(10);

        return view('admin.user-memberships.index', compact('gym', 'userMemberships'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create($gymId)
    {
        // Obtener el gimnasio por ID junto con sus membresías
        $gym = Gym::with('memberships')->findOrFail($gymId);

        // Obtener usuarios que pertenezcan al gimnasio y que no tengan una membresía activa en este gimnasio
        $users = User::whereHas('gyms', function($query) use ($gymId) {
            $query->where('gyms.id', $gymId);
        })
        ->whereDoesntHave('userMemberships', function($query) use ($gymId) {
            $query->where('isActive', true)->where('id_gym', $gymId);
        })->get();

        // Pasar los datos a la vista
        return view('admin.user-memberships.create', compact('users', 'gym'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del request
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_gym' => 'required|exists:gyms,id',
            'id_membership' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

      // Obtener el usuario y verificar su rol
    $user = User::with('roles')->findOrFail($validated['id_user']);
    $isSuperAdminOrAdmin = $user->roles->contains(function($role) {
        return in_array($role->name, ['Super Administrador', 'Administrador']);
    });

    if ($isSuperAdminOrAdmin) {
        // Verificar si el usuario ya tiene una membresía activa en el gimnasio
        $existingActiveMembership = UserMembership::where('id_user', $validated['id_user'])
            ->where('id_gym', $validated['id_gym'])
            ->where('isActive', true)
            ->first();

        if ($existingActiveMembership) {
            return redirect()->back()->withErrors(['id_user' => 'El usuario ya tiene una membresía activa en este gimnasio.']);
        }
    }

    // Obtener la membresía y determinar las fechas de inicio y fin
    $membership = Membership::findOrFail($validated['id_membership']);

    if ($membership->duration_type === 'Diaria') {
        $startDate = now()->startOfDay();
        $endDate = $startDate->copy()->endOfDay();
    } elseif ($membership->duration_type === 'Mensual') {
        $startDate = Carbon::parse($validated['start_date'])->setTimeFromTimeString(now()->toTimeString());
        $endDate = $startDate->copy()->addMonth();

        // Ajustar para meses con diferentes números de días
        if ($endDate->day != $startDate->day) {
            $endDate = $startDate->copy()->addMonth()->endOfMonth()->setTime(23, 59, 0);
        } else {
            $endDate->setTime(23, 59, 0);
        }
    } else {
        $startDate = Carbon::parse($validated['start_date'])->setTimeFromTimeString(now()->toTimeString());
        $endDate = Carbon::parse($validated['end_date'])->setTime(23, 59, 0);
    }

    // Calcular duración en días
    $durationDays = $startDate->diffInDays($endDate);

    // Determinar el estado de isActive basado en las fechas
    $isActive = $endDate->greaterThanOrEqualTo(Carbon::now());

        // Crear la nueva membresía del usuario
        UserMembership::create([
            'id_user' => $validated['id_user'],
            'id_gym' => $validated['id_gym'],
            'id_membership' => $validated['id_membership'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'isActive' => $isActive,
            'is_renewal' => false, // Nueva membresía, no es renovación
        ]);

        // Redirigir con un mensaje de éxito
        flash()->success('¡Membresía asignada exitosamente!');
        return redirect()->route('admin.gyms.user-memberships', $validated['id_gym']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Implementar si es necesario
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Obtener la membresía del usuario por ID
        $userMembership = UserMembership::findOrFail($id);

        // Obtener usuarios que no tengan una membresía activa (excluyendo la actual)
        $users = User::whereDoesntHave('userMemberships', function($query) use ($userMembership) {
            $query->where('isActive', true)->where('id', '!=', $userMembership->id);
        })->get();

        // Obtener el gimnasio relacionado con la membresía actual
        $gym = $userMembership->gym;

        // Obtener gimnasios
        $gyms = Gym::with('memberships')->get();

        // Pasar los datos a la vista
        return view('admin.user-memberships.edit', compact('userMembership', 'users', 'gyms', 'gym'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validar los datos del request
    $validated = $request->validate([
        'id_user' => 'required|exists:users,id',
        'id_gym' => 'required|exists:gyms,id',
        'id_membership' => 'required|exists:memberships,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    // Calcular duración en días
    $startDate = Carbon::parse($validated['start_date']);
    $endDate = Carbon::parse($validated['end_date'])->setTime(23, 59, 0);
    $durationDays = $startDate->diffInDays($endDate);

    // Determinar el estado de isActive basado en las fechas
    $isActive = $endDate->greaterThanOrEqualTo(Carbon::now());

    // Actualizar la membresía del usuario
    $userMembership = UserMembership::findOrFail($id);
    $userMembership->update([
        'id_user' => $validated['id_user'],
        'id_gym' => $validated['id_gym'],
        'id_membership' => $validated['id_membership'],
        'start_date' => $startDate,
        'end_date' => $endDate,
        'duration_days' => $durationDays,
        'isActive' => $isActive,
    ]);

    // Obtener el ID del gimnasio de la membresía actualizada
    $gymId = $validated['id_gym'];

    // Redirigir con un mensaje de éxito
    flash()->success('¡Membresía actualizada exitosamente!');
    return redirect()->route('admin.gyms.user-memberships', ['id' => $gymId]);
}


    public function renew($id)
    {
        // Obtener la membresía del usuario por ID
        $userMembership = UserMembership::with('user', 'gym', 'membership')->findOrFail($id);
        $user = $userMembership->user;
        $gym = $userMembership->gym;
        $memberships = $gym->memberships;

        // Pasar los datos a la vista
        return view('admin.user-memberships.renew', compact('userMembership', 'user', 'gym', 'memberships'));
    }

    public function storeRenewal(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'id_membership' => 'required|exists:memberships,id',
            ]);

            $userMembership = UserMembership::findOrFail($id);

            $now = Carbon::now();
            $endDateCurrent = Carbon::parse($userMembership->end_date);
            if ($endDateCurrent->diffInDays($now, false) > 5) {
                return redirect()->back()->withErrors(['error' => 'Solo puedes renovar tu membresía hasta 5 días antes de su vencimiento.']);
            }

            $startDate = $endDateCurrent->copy()->addDay()->startOfDay(); // El día después de la fecha de vencimiento actual a las 00:00:00
            $membership = Membership::findOrFail($validated['id_membership']);

            $durationType = $membership->duration_type;
            $endDate = $this->calculateEndDate($startDate, $durationType);

            if (!$endDate) {
                return redirect()->back()->withErrors(['error' => 'Tipo de duración de membresía no válido.']);
            }

            $newMembership = UserMembership::create([
                'id_user' => $userMembership->id_user,
                'id_gym' => $userMembership->id_gym,
                'id_membership' => $validated['id_membership'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'duration_days' => $startDate->diffInDays($endDate),
                'isActive' => false, // No activa hasta que la actual termine
                'is_renewal' => false, // Nueva membresía, no es renovación
            ]);

            // Actualizar la membresía actual según la condición especificada
            if (Carbon::parse($userMembership->end_date)->lessThan($now) && $userMembership->isActive) {
                $userMembership->update(['isActive' => false, 'is_renewal' => false]);
            } else {
                $userMembership->update(['is_renewal' => true]);
            }

            // Activar la nueva membresía si la actual ya está vencida
            $this->activateNewMembership($userMembership, $newMembership);

            flash()->success('¡Membresía renovada exitosamente! La nueva membresía comenzará cuando la actual termine.');
            return redirect()->route('admin.user-memberships.history', ['userId' => $userMembership->id_user]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error durante la renovación: ' . $e->getMessage()]);
        }
    }



    private function calculateEndDate($startDate, $durationType)
    {
        switch ($durationType) {
            case DurationType::SEMANAL:
                return $startDate->copy()->addDays(7)->endOfDay();
            case DurationType::MENSUAL:
                    $endDate = $startDate->copy()->addMonth();
                    $endDate->addDay(); // Agregar un día adicional
                    return $endDate->endOfDay();
            case DurationType::ANUAL:
                return $startDate->copy()->addYear()->endOfDay();
            case DurationType::DIARIA:
                return $startDate->copy()->addDay()->endOfDay();
            default:
                return null;
        }
    }

    private function activateNewMembership($oldMembership, $newMembership)
    {
        $now = Carbon::now();
        if (Carbon::parse($oldMembership->end_date)->lessThan($now)) {
            $oldMembership->update(['isActive' => false]);
            $newMembership->update(['isActive' => true]);
        }
    }

    public function getActiveMembership($userId)
    {
        $currentDate = Carbon::now();
        return UserMembership::where('id_user', $userId)
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->where('isActive', true)
            ->first();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userMembership = UserMembership::findOrFail($id);
        $gymId = $userMembership->id_gym;
        $userMembership->delete();

        // Redirigir con un mensaje de éxito
        flash()->success('¡Membresía eliminada exitosamente!');
        return redirect()->route('admin.gyms.user-memberships', $gymId);
    }


}
