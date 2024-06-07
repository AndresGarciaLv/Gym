<?php

namespace App\Http\Controllers\Admin;

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
            'end_date' => 'required|date|after:start_date',
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
    
         // Calcular duración en días
    $currentTimestamp = Carbon::now();
    $startDate = Carbon::parse($validated['start_date'])->setTimeFrom($currentTimestamp);
    $endDate = Carbon::parse($validated['end_date'])->setTime(23, 59, 0);
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

        // Obtener gimnasios
        $gyms = Gym::with('memberships')->get();

        // Pasar los datos a la vista
        return view('admin.user-memberships.edit', compact('userMembership', 'users', 'gyms'));
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

        // Redirigir con un mensaje de éxito
        flash()->success('¡Membresía actualizada exitosamente!');
        return redirect()->route('admin.user-memberships.index');
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
