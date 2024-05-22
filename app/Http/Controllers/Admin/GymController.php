<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use Illuminate\Http\Request;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gyms = Gym::paginate(10); 
        return view('admin.gyms.index', compact('gyms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gyms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
    
        Gym::create($request->all());
    
        flash()->success('¡El Gimnasio se ha creado correctamente!');
        return redirect()->route('admin.gyms.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $gym = Gym::findOrFail($id);
    return view('admin.gyms.show', compact('gym'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gym = Gym::findOrFail($id);
        return view('admin.gyms.edit', compact('gym'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'isActive' => 'required|boolean',
        ]);
    
        $gym = Gym::findOrFail($id);
        $gym->update($request->all());

        flash()->success('¡El Gimnasio se ha actualizado correctamente!');
        return redirect()->route('admin.gyms.index');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $gym = Gym::findOrFail($id);
    $gym->delete();

    flash()->success('¡El Gimnasio se ha eliminado correctamente!');
    return redirect()->route('admin.gyms.index');
}

public function users($id)
{
    $gym = Gym::findOrFail($id);
    $users = $gym->users()->paginate(10);

    return view('admin.gyms.users', compact('gym', 'users'));
}

}
