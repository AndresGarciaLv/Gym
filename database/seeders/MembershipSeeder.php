<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gyms = Gym::all();

        foreach ($gyms as $gym) {
            Membership::create([
                'id_gym' => $gym->id,
                'name' => 'Membresia Semanal',
                'description' => 'Acceso basico a todo el equipo del GYM por 7 días',
                'price' => 350.00,
                'duration_type' => 'Semanal',
            
            ]);

            Membership::create([
                'id_gym' => $gym->id,
                'name' => 'Membresia Bronce',
                'description' => 'Acceso basico a todo el equipo del GYM',
                'price' => 350.00,
                'duration_type' => 'Mensual',
             
            ]);

            Membership::create([
                'id_gym' => $gym->id,
                'name' => 'Membresia de Plata',
                'description' => 'Acceso total al GYM, y personalizado.',
                'price' => 750.00,
                'duration_type' => 'Mensual',
              
            ]);
            
            Membership::create([
                'id_gym' => $gym->id,
                'name' => 'Membresia VIP',
                'description' => 'Acceso total al GYM, con Entrenador personal y acceso a bebidas',
                'price' => 900.00,
                'duration_type' => 'Mensual',
                
            ]);

            Membership::create([
                'id_gym' => $gym->id,
                'name' => 'Membresia Oro',
                'description' => 'Acceso total al GYM, con Entrenador personal y acceso a bebidas',
                'price' => 1000.00,
                'duration_type' => 'Mensual',
               
            ]);
            Membership::create([
                'id_gym' => $gym->id,
                'name' => 'Visita',
                'description' => 'Acceso basico a todo el equipo del GYM por 1 día',
                'price' => 350.00,
                'duration_type' => 'Diaria',
            
            ]);
        }

    }
}
