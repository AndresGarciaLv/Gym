<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $gymData = $request->all();

        // Manejo de la foto del gimnasio
        if ($request->hasFile('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = uniqid() . '.' . $extension;
            $request->file('photo')->storeAs('public/photos', $filename);
            $gymData['photo'] = 'photos/' . $filename;
        }

        Gym::create($gymData);

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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_photo' => 'nullable|boolean',
        ]);
    
        $gym = Gym::findOrFail($id);
        $gymData = $request->all();
    
        // Manejo de la foto del gimnasio
        if ($request->input('remove_photo')) {
            if ($gym->photo) {
                Storage::disk('public')->delete($gym->photo);
                $gymData['photo'] = null;  // Asegúrate de actualizar el campo 'photo' a null
            }
        } elseif ($request->hasFile('photo')) {
            if ($gym->photo) {
                Storage::disk('public')->delete($gym->photo);
            }
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = uniqid() . '.' . $extension; // Genera un nombre único para la foto
            $request->file('photo')->storeAs('public/photos', $filename);
            $gymData['photo'] = 'photos/' . $filename;
        }
    
        $gym->update($gymData);
    
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
