<?php

use App\Http\Controllers\Admin\GymController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CredentialController;

Route::middleware(['guest'])->group(function () {
    Route::get('/iniciar-sesion', function () {
        return view('auth.login');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home.administrador');
    })->middleware('can:Dashboard-Adm')->name('Dashboard-Adm');

    Route::get('/panel-staff', function () {
        return view('home.staff');
    })->middleware('can:Dashboard-St')->name('Dashboard-St');

    Route::get('/users/{user}/generate-credential', [CredentialController::class, 'printCredential'])
     ->name('admin.users.generate-credential');
     Route::get('/admin/users/generate-credential/{user}/pdf', [CredentialController::class, 'generatePDF'])->name('admin.users.generate-credential.pdf');

/*     Route::get('/users/{user}/generate-credential', [CredentialController::class, 'generatePDF'])->name('admin.users.generate-credential'); */

    Route::resource('users', UserController::class)->middleware('can:admin.users')->names('admin.users');
    Route::resource('gyms', GymController::class)->middleware('can:admin.gyms')->names('admin.gyms');
    Route::get('admin/gyms/{id}/users', [GymController::class, 'users'])->middleware('can:admin.gyms.users')->name('admin.gyms.users');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
