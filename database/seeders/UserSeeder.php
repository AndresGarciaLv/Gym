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
            'birthdate'=> '1980-11-25',
            'phone_number'=> '9987352189',
            'phone_emergency'=> '9987352183',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Administrador');

        User::create([
            'name'=> 'Andrés Leyva',
            'email'=> 'andresleyva@gmail.com',
            'birthdate'=> '1999-05-12',
            'phone_number'=> '9987352189',
            'phone_emergency'=> '9987352183',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Staff');

        User::create([
            'name'=> 'Omar Caballero',
            'email'=> 'ocaballero@gmail.com',
            'birthdate'=> '2000-12-15',
            'phone_number'=> '99875123454',
            'phone_emergency'=> '9987312433',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Cliente');

        User::create([
            'name'=> 'AndrésGL',
            'email'=> 'andresgarciia09@gmail.com',
            'birthdate'=> '199-07-01',
            'phone_number'=> '9987824454',
            'phone_emergency'=> '9985352422',
            'password'=> Hash::make('Toluca10')
        ])->assignRole('Super Administrador');

/*         User::factory(200)->create(); */
    }
}
