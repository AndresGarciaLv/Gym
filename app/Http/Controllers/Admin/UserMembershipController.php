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
    public function index()
    {
        $userMemberships = UserMembership::with(['user', 'gym', 'membership'])->paginate(10);
        return view('admin.user-memberships.index', compact('userMemberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener usuarios que no tengan una membresía activa
        $users = User::whereDoesntHave('userMemberships', function($query) {
            $query->where('isActive', true);
        })->get();

        // Obtener gimnasios
        $gyms = Gym::with('memberships')->get();

        // Pasar los datos a la vista
        return view('admin.user-memberships.create', compact('users', 'gyms'));
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

        // Calcular duración en días
        $startDate = Carbon::parse($validated['start_date']);
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
        return redirect()->route('admin.user-memberships.index');
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
        $userMembership->delete();

        // Redirigir con un mensaje de éxito
        flash()->success('¡Membresía eliminada exitosamente!');
        return redirect()->route('admin.user-memberships.index');
    }
}
