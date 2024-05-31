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
            'admin.gyms' => ['Super Administrador', 'Administrador'],
            'admin.gyms.users' => ['Super Administrador', 'Administrador'],
            'admin.memberships' => ['Super Administrador', 'Administrador'],
            'admin.memberships.gyms' => ['Super Administrador', 'Administrador'],

            'admin.user-memberships' => ['Super Administrador', 'Administrador'],
            
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
