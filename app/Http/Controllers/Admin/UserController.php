<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gym; // Asegúrate de importar el modelo Gym
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
        $gyms = Gym::all(); // Obtener todos los gimnasios
        return view('admin.users.create', compact('roles', 'gyms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = $request->input('role');
    
        // Validación de datos con reglas condicionales
        $request->validate([
            'name' => 'required|string|max:255',
            'email' =>  $role !== 'Cliente' ? 'required|email|unique:users,email' : 'nullable|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'gyms' => 'required|array',
            'gyms.*' => 'exists:gyms,id',
            'password' => $role !== 'Cliente' ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed',
        ]);
    
        // Preparación de datos para la creación del usuario
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'isActive' => $request->isActive,
        ];
    
        // Si el rol no es "Cliente", incluir la contraseña
        if ($role !== 'Cliente') {
            $userData['password'] = bcrypt($request->password);
        }
    
        // Crear el usuario
        $user = User::create($userData);
        $user->assignRole($request->role);
        $user->gyms()->attach($request->gyms); // Asignar los gimnasios seleccionados
    
        flash()->success('¡El Usuario se ha Creado correctamente!');
        return redirect()->route('admin.users.index');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $gyms = Gym::all(); // Obtener todos los gimnasios
        $userRole = $user->roles->first();

        return view('admin.users.edit', compact('user', 'roles', 'userRole', 'gyms'));
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
            'role' => 'required|exists:roles,name',
            'gyms' => 'required|array',
            'gyms.*' => 'exists:gyms,id',
            'isActive' => 'required|boolean',
        ]);
    
        // Actualizar los datos del usuario
        $userData = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'isActive' => $request->isActive,
        ];
    
        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }
    
        $user->update($userData);
    
        // Sincronizar roles y gimnasios
        $user->syncRoles($request->role);
        $user->gyms()->sync($request->gyms); // Sincronizar los gimnasios seleccionados
    
        // Redirigir con un mensaje de éxito
        flash()->success('¡El Usuario se ha Actualizado correctamente!');
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        flash()->success('¡El Usuario se ha Eliminado correctamente!');
        return redirect()->route('admin.users.index');
    }
}
