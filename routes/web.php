<?php

use App\Http\Controllers\Admin\GymController;
use App\Http\Controllers\Admin\GymLogController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserMembershipController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Middleware\CheckGymMembership;
use App\Http\Middleware\CheckGymOwnership;
use App\Http\Middleware\CheckGymUserOwnership;
use App\Http\Middleware\CheckUserEditPermissions;
use GuzzleHttp\Middleware;

Route::middleware(['guest'])->group(function () {
    Route::get('/iniciar-sesion', function () {
        return view('auth.login');
    });
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [Dashboard::class, 'superAdmin'])
        ->middleware('can:Dashboard-SupAdm')
        ->name('Dashboard-SupAdm');

    Route::get('/', function () {
        return view('home.administrador');
    })->middleware('can:Dashboard-Adm')->name('Dashboard-Adm');

    Route::get('/panel-staff', function () {
        return view('home.staff');
    })->middleware('can:Dashboard-St')->name('Dashboard-St');

    Route::get('/users/{user}/generate-credential', [CredentialController::class, 'printCredential'])->name('admin.users.generate-credential');
     Route::get('/admin/users/generate-credential/{user}/pdf', [CredentialController::class, 'generatePDF'])->name('admin.users.generate-credential.pdf');

/*     Route::get('/users/{user}/generate-credential', [CredentialController::class, 'generatePDF'])->name('admin.users.generate-credential'); */
/*
    Route::resource('users', UserController::class)->middleware('can:admin.users')->names('admin.users'); */
  /* RUTAS DE USUARIOS */
  Route::get('users/create', [UserController::class, 'create'])
    ->middleware('can:admin.users.create')
    ->name('admin.users.create');

    Route::resource('users', UserController::class)
    ->middleware('can:admin.users')
    ->names('admin.users')
    ->except(['create','edit']);

    Route::get('users/{user}/edit', [UserController::class, 'edit'])
    ->middleware(['auth', CheckUserEditPermissions::class])
    ->name('admin.users.edit');

    /* RUTAS GIMNASIOS */
    Route::get('gyms/create', [GymController::class, 'create'])
    ->middleware('can:admin.gyms.create')
    ->name('admin.gyms.create');

    Route::resource('gyms', GymController::class)
    ->middleware('can:admin.gyms')
    ->names('admin.gyms')
    ->except(['create', 'edit', 'update']);

    Route::get('gyms/{gym}/edit', [GymController::class, 'edit'])
    ->middleware(['auth', CheckGymOwnership::class])
    ->name('admin.gyms.edit');

    Route::put('gyms/{gym}', [GymController::class, 'update'])
    ->middleware(['auth', CheckGymOwnership::class])
    ->name('admin.gyms.update');

    Route::get('admin/gyms/{id}/users', [GymController::class, 'users'])
    ->middleware(['auth', CheckGymUserOwnership::class])
    ->name('admin.gyms.users');

  /*   Route::get('admin/gyms/{id}/users', [GymController::class, 'users'])->middleware('can:admin.gyms.users')->name('admin.gyms.users'); */

    Route::resource('memberships', MembershipController::class)->middleware('can:admin.memberships')->names('admin.memberships');
    Route::get('admin/memberships/{id}/gyms', [MembershipController::class, 'memberships'])->middleware('can:admin.memberships.gyms')->name('admin.memberships.gyms');

    Route::get('user-memberships/create/{gym}', [UserMembershipController::class, 'create'])
    ->middleware(['auth', CheckGymMembership::class])
    ->name('admin.user-memberships.create');
    Route::resource('user-memberships', UserMembershipController::class)->middleware('can:admin.user-memberships')->names('admin.user-memberships')->except(['create']);;
    Route::get('/admin/gyms/{id}/user-memberships', [UserMembershipController::class, 'membershipsByGym'])->name('admin.gyms.user-memberships');

    Route::get('admin/user-memberships/history/{userId}', [UserMembershipController::class, 'userMembershipsHistory'])->name('admin.user-memberships.history');
    Route::get('/user-memberships/{id}/renew', [UserMembershipController::class, 'renew'])->name('admin.user-memberships.renew');
    Route::post('/user-memberships/{id}/renew', [UserMembershipController::class, 'storeRenewal'])->name('admin.user-memberships.storeRenewal');

    //REGISTRO DE ENTRADA / SALIDA
    Route::post('admin/gym-log/{gym}/entry', [GymLogController::class, 'logEntry'])->name('gym-log.entry');
    Route::post('admin/gym-log/{gym}/exit', [GymLogController::class, 'logExit'])->name('gym-log.exit');

    Route::get('admin/gym-log/{gym}', [GymLogController::class, 'index'])->name('admin.gym-log.index');
    Route::post('admin/gym-log/{gym}/action', [GymLogController::class, 'logAction'])->name('admin.gym-log.logAction');

    //STAFF ROUTES
    Route::resource('staffs', StaffController::class)->middleware('can:staffs')->names('staffs');
    Route::get('clients', [StaffController::class, 'clients'])->middleware('can:staffs.clients')->name('staffs.clients');


});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
