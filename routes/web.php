<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;


Route::middleware(['guest'])->group(function () {
    Route::get('/iniciar-sesion', function () {
        return view('auth.login');
    });
    Route::get('/iniciar-sesion2', function () {
        return view('auth.login2');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home.administrador');
    })->name('Dashboard-Adm');

    Route::get('/panel-staff', function () {
        return view('home.staff');
    })->name('Dashboard-St');


    Route::resource('users', UserController::class)->names('admin.users');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
