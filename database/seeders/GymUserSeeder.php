<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Database\Seeder;

class GymUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Obtener todos los usuarios y gimnasios
       $users = User::all();
       $gyms = Gym::all();

       // Si no hay usuarios o gimnasios, lanzar una excepción
       if ($users->isEmpty() || $gyms->isEmpty()) {
           throw new \Exception('No users or gyms found to assign.');
       }

       // Asignar usuarios a gimnasios según su rol
       foreach ($users as $user) {
           if ($user->hasRole('Staff') || $user->hasRole('Cliente') || $user->hasRole('Checador')) {
               // Asignar un solo gimnasio aleatorio a los usuarios con rol 'Staff' o 'Cliente'
               $user->gyms()->attach(
                   $gyms->random(1)->pluck('id')->toArray()
               );
           } elseif ($user->hasRole('Super Administrador') || $user->hasRole('Administrador')) {
               // Asignar entre 1 y 3 gimnasios aleatorios a los usuarios con rol 'Super Administrador' o 'Administrador'
               $user->gyms()->attach(
                   $gyms->random(rand(1, 3))->pluck('id')->toArray()
               );
           }
       }
   }
}
