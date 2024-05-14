<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;  // Usar el modelo Role, no la interfaz


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);  // Usa findOrFail para manejar usuarios no encontrados
        $roles = Role::all();  // Obtén todos los roles disponibles
        $userRole = $user->roles->first();  // Asume que cada usuario tiene un solo rol

        return view('admin.users.show', compact('user', 'roles', 'userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);  // Usa findOrFail para manejar usuarios no encontrados
        $roles = Role::all();  // Obtén todos los roles disponibles
        $userRole = $user->roles->first();  // Asume que cada usuario tiene un solo rol

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    // Asegúrate de que 'role' se envíe como un array si es necesario
    $user->syncRoles($request->role); // Convirtiendo en array para asegurar compatibilidad
    return redirect()->route('admin.users.edit', $user->id)->with('success', 'Usuario actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
