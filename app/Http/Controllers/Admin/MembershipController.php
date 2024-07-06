<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DurationType;
use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\Membership;
use App\Models\UserMembership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::paginate(10);
        return view('admin.memberships.index', compact('memberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $user = Auth::user();

    if ($user->hasRole('Super Administrador')) {
        $gyms = Gym::all();
    } elseif ($user->hasRole('Administrador')) {
        $gyms = $user->load('gyms')->gyms; // Eager loading gyms relation
    } else {
        $gyms = collect(); // Empty collection if the user is not Super Administrador or Administrador
    }

    return view('admin.memberships.create', compact('gyms'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_gym' => 'required|exists:gyms,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration_type' => 'nullable|in:' . implode(',', array_column(DurationType::cases(), 'value')),
        ]);

        try {
            DB::beginTransaction();

            $exists = Membership::where('id_gym', $request->id_gym)
                                ->where('name', $request->name)
                                ->lockForUpdate()
                                ->exists();

            if ($exists) {
                DB::rollBack();
                return back()->withErrors(['name' => 'Ya existe una membresía con ese nombre para el gimnasio seleccionado.']);
            }

            Membership::create($request->all());

            DB::commit();

            flash()->success('¡La Membresía se ha creado correctamente!');
            return redirect()->route('admin.memberships.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al crear la membresía. Por favor, inténtelo de nuevo.']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $membership = Membership::findOrFail($id);
        return view('admin.memberships.show', compact('membership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        $user = Auth::user();

        if ($user->hasRole('Administrador')) {
            // If the user is an Administrador, eager load only the gyms the user belongs to
            $gyms = $user->load('gyms')->gyms;
        } else {
            // If the user is not an Administrador, get all gyms
            $gyms = Gym::all();
        }

        return view('admin.memberships.edit', compact('membership', 'gyms'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_gym' => 'required|exists:gyms,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration_type' => 'nullable|in:' . implode(',', array_column(DurationType::cases(), 'value')),
        ]);

        $membership = Membership::findOrFail($id);
        $membership->update($request->all());

        flash()->success('¡La Membresía se ha actualizado correctamente!');
        return redirect()->route('admin.memberships.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->delete();

        flash()->success('¡La Membresía se ha eliminado correctamente!');
        return redirect()->route('admin.memberships.index');
    }


    /**
     * Display memberships for a specific gym.
     */
    public function memberships($id)
    {
        $gym = Gym::findOrFail($id);
        $memberships = $gym->memberships()->paginate(10);

        return view('admin.memberships.gyms', compact('gym', 'memberships'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gym_id' => 'required|exists:gyms,id',
            'id_membership' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date)->setTime(23, 59, 0);
            $durationDays = $startDate->diffInDays($endDate);

            $activeMembership = UserMembership::where('user_id', $request->user_id)
                                               ->where('is_active', true)
                                               ->exists();

            if ($activeMembership) {
                return back()->withErrors(['user_id' => 'El usuario ya tiene una membresía activa.']);
            }

            UserMembership::create([
                'user_id' => $request->user_id,
                'gym_id' => $request->gym_id,
                'id_membership' => $request->membership_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_active' => true,
            ]);

            DB::commit();

            return redirect()->route('admin.memberships.index')->with('success', '¡Membresía asignada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Ocurrió un error al asignar la membresía. Por favor, inténtelo de nuevo.']);
        }
    }

}
