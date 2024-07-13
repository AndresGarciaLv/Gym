<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gym; // Asegúrate de importar el modelo Gym
use App\Models\Membership;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

        $rules = [
            'name' => 'required|string|max:255',
            'email' => $role !== 'Cliente' ? 'required|email|unique:users,email' : 'nullable|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'password' => $role !== 'Cliente' ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed',
            'isActive' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        if (in_array($role, ['Super Administrador', 'Administrador'])) {
            $rules['gyms'] = 'required|array';
            $rules['gyms.*'] = 'exists:gyms,id';
        } else {
            $rules['single_gym'] = 'required|exists:gyms,id';
        }

        $request->validate($rules);

        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'birthdate' => $request->birthdate,
                'isActive' => $request->isActive,
            ];

            if ($role !== 'Cliente') {
                $userData['password'] = bcrypt($request->password);
            }

            $user = User::create($userData);
            $user->assignRole($request->role);

            if ($request->hasFile('photo')) {
                $extension = $request->file('photo')->getClientOriginalExtension();
                $filename = $user->code . '.' . $extension;
                $request->file('photo')->storeAs('public/photos', $filename);
                $user->photo = 'photos/' . $filename;
                $user->save();
            }

            if (in_array($role, ['Super Administrador', 'Administrador'])) {
                $user->gyms()->attach($request->gyms);
            } else {
                $user->gyms()->attach($request->single_gym);
            }

            flash()->success('¡El Usuario se ha Creado correctamente!');
        } catch (\Exception $e) {
            flash()->error('Ocurrió un error al crear el usuario: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

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
        $role = $request->input('role');

        $rules = [
            'name' => 'required|string|max:255',
            'name_contact' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($user->id)], // Ajustar para permitir el mismo correo del usuario actual
            'phone_number' => 'nullable|string|max:10',
            'phone_emergency' => 'nullable|string|max:10',
            'birthdate' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'isActive' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_photo' => 'nullable|boolean',
        ];

        // Validación específica según el rol
        if (in_array($role, ['Super Administrador', 'Administrador'])) {
            $rules['gyms'] = 'required|array';
            $rules['gyms.*'] = 'exists:gyms,id';
        } else {
            $rules['single_gym'] = 'required|exists:gyms,id';
        }

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            // Redirigir con los errores y los datos antiguos
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Por favor corrija los errores en el formulario.');
        }


        // Actualizar los datos del usuario
        $userData = [
            'name' => $request->name,
            'name_contact' => $request->name_contact,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'phone_emergency' => $request->phone_emergency,
            'birthdate' => $request->birthdate,
            'isActive' => $request->isActive,
        ];

        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        // Manejo de la foto de perfil
        if ($request->input('remove_photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
                $user->photo = null;
            }
        } elseif ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = $user->code . '.' . $extension;
            $request->file('photo')->storeAs('public/photos', $filename);
            $user->photo = 'photos/' . $filename;
        }

        $user->update($userData);

        // Sincronizar roles y gimnasios
        $user->syncRoles($request->role);

        if (in_array($role, ['Super Administrador', 'Administrador'])) {
            $user->gyms()->sync($request->gyms);
        } else {
            $user->gyms()->sync($request->single_gym);
        }

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
