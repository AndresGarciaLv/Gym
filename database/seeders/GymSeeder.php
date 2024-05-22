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
        ]);

        Gym::create([
            'name' => 'Estamina GYM',
            'location' => 'Av. Rancho viejo Mz 1 Lt 2',
            'isActive' => true,
        ]);

        Gym::create([
            'name' => 'Firenow GYM',
            'location' => '789 South Street',
            'isActive' => true,
        ]);
    }
}
