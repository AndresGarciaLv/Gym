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
      // Verificar y crear roles si no existen
      $roles = ['Administrador', 'Staff', 'Cliente', 'Super Administrador'];
      foreach ($roles as $role) {
          Role::firstOrCreate(['name' => $role]);
      }

      // Contraseña encriptada común para todos los usuarios
      $password = Hash::make('Toluca10');

      // Array de usuarios a crear
      $users = [
          [
              'name' => 'Andrés Garcia',
              'email' => 'andresgarcia@gmail.com',
              'birthdate' => '1980-11-25',
              'phone_number' => '9987352189',
              'phone_emergency' => '9987352183',
              'role' => 'Administrador',
          ],
          [
            'name' => 'Kevin Chan',
            'email' => 'kevinc@gmail.com',
            'birthdate' => '1980-11-25',
            'phone_number' => '9987352189',
            'phone_emergency' => '9987352183',
            'role' => 'Staff',
        ],
          [
              'name' => 'Andrés Leyva',
              'email' => 'andresleyva@gmail.com',
              'birthdate' => '1999-05-12',
              'phone_number' => '9987352189',
              'phone_emergency' => '9987352183',
              'role' => 'Staff',
          ],
          [
              'name' => 'Omar Caballero',
              'email' => 'ocaballero@gmail.com',
              'birthdate' => '2000-12-15',
              'phone_number' => '9987352189',
              'phone_emergency' => '9987352189',
              'role' => 'Cliente',
          ],
          [
              'name' => 'AndrésGL',
              'email' => 'andresgarciia09@gmail.com',
              'birthdate' => '1999-07-01',
              'phone_number' => '9987824454',
              'phone_emergency' => '9985352422',
              'role' => 'Super Administrador',
          ],
          [
            'name' => 'Checador EricksGYM',
            'email' => 'checador@gmail.com',
            'birthdate' => '1999-07-01',
            'phone_number' => '9987824454',
            'phone_emergency' => '9985352422',
            'role' => 'Checador',
        ],
      ];

      // Crear usuarios y asignar roles
      foreach ($users as $userData) {
          $user = User::create([
              'name' => $userData['name'],
              'email' => $userData['email'],
              'birthdate' => $userData['birthdate'],
              'phone_number' => $userData['phone_number'],
              'phone_emergency' => $userData['phone_emergency'],
              'password' => $password,
          ]);
          $user->assignRole($userData['role']);
      }

      // Crear usuarios adicionales para pruebas
      // User::factory(200)->create();
    }
}
