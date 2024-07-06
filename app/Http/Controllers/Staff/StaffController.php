<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Gym;
use App\Models\Membership;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Auth::user();
        $gym = $staff->gyms()->first(); // El Staff pertenece a un solo gimnasio

        // Obtener todas las membresías activas de los usuarios que pertenecen al mismo gimnasio
        $userMemberships = UserMembership::where('id_gym', $gym->id)
            ->where('isActive', true)
            ->with(['user', 'gym', 'membership'])
            ->paginate(10);

        return view('staffs.index', compact('userMemberships'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = Auth::user();
        $gym = $staff->gyms()->first(); //Se obtiene el GYM del Staff
        $memberships = $gym->memberships;

        return view('staffs.create-client', compact('gym', 'memberships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone_number' => 'nullable|string|max:10',
            'birthdate' => 'nullable|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'id_membership' => 'required|exists:memberships,id',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'isActive' => true,
        ];

        $user = User::create($userData);
        $user->assignRole('Cliente');

        $gym = Auth::user()->gyms()->first(); // Asumimos que el Staff pertenece a un solo gimnasio
        $user->gyms()->attach($gym->id);

        $startDate = Carbon::parse($request->start_date)->setTimeFromTimeString(now()->toTimeString());
        $endDate = Carbon::parse($request->end_date)->setTime(23, 59, 0);
        $durationDays = $startDate->diffInDays($endDate);

        UserMembership::create([
            'id_user' => $user->id,
            'id_gym' => $gym->id,
            'id_membership' => $request->id_membership,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'isActive' => true,
        ]);
        flash()->success('¡Cliente creado y membresía asignada exitosamente!');
        return redirect()->route('staffs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function clients()
    {
        $staff = Auth::user();
        $gym = $staff->gyms()->first(); // El Staff pertenece a un solo gimnasio

        // Obtener todos los usuarios con el rol de 'Cliente' que pertenecen al mismo gimnasio
        $users = User::whereHas('roles', function($query) {
                $query->where('name', 'Cliente');
            })
            ->whereHas('gyms', function($query) use ($gym) {
                $query->where('gyms.id', $gym->id);
            })
            ->get();

        return view('staffs.clients', compact('users', 'gym'));
    }
}
