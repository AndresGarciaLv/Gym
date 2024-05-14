<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'Andrés Garcia',
            'email'=> 'andresgarcia@gmail.com',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Administrador');

        User::create([
            'name'=> 'Andrés Leyva',
            'email'=> 'andresleyva@gmail.com',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Staff');

        User::create([
            'name'=> 'Omar Caballero',
            'email'=> 'ocaballero@gmail.com',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Cliente');

        User::create([
            'name'=> 'AndrésGL',
            'email'=> 'andresgarciia09@gmail.com',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Super Administrador');

        User::factory(200)->create();
    }
}
