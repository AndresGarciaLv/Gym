<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\Membership;
use Illuminate\Http\Request;
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
        $gyms = Gym::all();
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
        return view('admin.memberships.edit', compact('membership'));
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
            'duration_days' => 'required|integer|min:1',
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
}
