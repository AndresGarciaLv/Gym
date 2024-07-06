<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir roles
        $roles = [
            'Super Administrador',
            'Administrador',
            'Staff',
            'Cliente',
        ];

        // Crear o buscar roles
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Definir permisos y asignar roles
        $permissions = [
            'Dashboard-Adm' => ['Super Administrador', 'Administrador'],
            'admin.users' => ['Super Administrador', 'Administrador'],

            //GIMNASIOS
            'admin.gyms' => ['Super Administrador', 'Administrador'],
            'admin.gyms.create' => ['Super Administrador'],
            'admin.gyms.edit' => ['Super Administrador', 'Administrador'],
            'admin.gyms.update' => ['Super Administrador', 'Administrador'],
            'admin.gyms.users' => ['Super Administrador', 'Administrador'],

            //MEMBRESÍAS
            'admin.memberships' => ['Super Administrador', 'Administrador'],
            'admin.memberships.gyms' => ['Super Administrador', 'Administrador'],

            //Recursos de User-Memberships
            'admin.user-memberships' => ['Super Administrador', 'Administrador','Staff'],
            //Asignar Membresía
            'admin.user-memberships.create' => ['Super Administrador', 'Administrador', 'Staff'],

            'staffs' => ['Staff'],
            'Dashboard-St' => ['Staff'],
            'staffs.clients' => ['Staff'],
        ];

        // Crear o buscar permisos y sincronizar roles
        foreach ($permissions as $permission => $roles) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $perm->syncRoles($roles);
        }
    }
}
