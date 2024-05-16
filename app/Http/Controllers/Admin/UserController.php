<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10); // Paginación para una mejor gestión de usuarios
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $userRole = $user->roles->first();

        return view('admin.users.show', compact('user', 'roles', 'userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $userRole = $user->roles->first();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:10', // Añadir validación para phone_number
            'birthdate' => 'nullable|string', // Añadir validación para birthdate
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name'
        ]);
    
        // Actualizar los datos del usuario
        $userData = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
        ];
    
        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }
    
        $user->update($userData);
    
        // Sincronizar roles
        $user->syncRoles($request->role);
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.users.edit', $user->id)->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
