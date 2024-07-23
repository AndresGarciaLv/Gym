<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Gym;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('roles', 'gyms'); // Cargar los roles y gimnasios del usuario
        $roles = Role::all();
        $gyms = Gym::all(); // Obtener todos los gimnasios
        $userRole = $user->roles->first();

        return view('profile.edit', compact('user', 'roles', 'userRole', 'gyms'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->only(['name', 'email', 'phone_number', 'birthdate']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
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
        $user->save();
        flash()->success('¡Perfil Actualizado exitosamente!');

        // No es necesario actualizar roles y gimnasios en el perfil
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
