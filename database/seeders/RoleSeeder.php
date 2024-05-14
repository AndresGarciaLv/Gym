<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $role1 = Role::create(['name'=>'Super Administrador']);
        $role2 = Role::create(['name'=>'Administrador']);
        $role3 = Role::create(['name'=>'Staff']);
        $role4 = Role::create(['name'=>'Cliente']);

        Permission::create(['name'=>'Dashboard-Adm'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'admin.users'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'Dashboard-St'])->syncRoles([$role3]);;
    }
}
