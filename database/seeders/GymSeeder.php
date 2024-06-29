<?php

namespace Database\Seeders;

use App\Models\Gym;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gym::create([
            'name' => 'Ericks GYM',
            'location' => 'Av. 20 de Noviembre Mz 14 Lt 2',
            'isActive' => true,
            'phone_number' => '9987654321',
            'email' => 'ericksgym@gmail.com',


        ]);

        Gym::create([
            'name' => 'Estamina GYM',
            'location' => 'Av. Rancho viejo Mz 1 Lt 2',
            'isActive' => true,
            'phone_number' => '9987456621',
            'email' => 'estaminagym@gmail.com',
        ]);

        Gym::create([
            'name' => 'Firenow GYM',
            'location' => '789 South Street',
            'isActive' => true,
            'phone_number' => '9983445724',
            'email' => 'firenowgym@gmail.com',
        ]);
    }
}
