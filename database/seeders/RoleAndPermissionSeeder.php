<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Buat permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage menus']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage users', 'manage menus']);

    }


}
