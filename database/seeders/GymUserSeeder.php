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

        // Asignar usuarios a gimnasios de forma aleatoria
        foreach ($users as $user) {
            // Asignar entre 1 y 3 gimnasios aleatorios a cada usuario
            $user->gyms()->attach(
                $gyms->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
