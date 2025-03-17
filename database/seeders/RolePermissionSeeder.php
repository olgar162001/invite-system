<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        $permissions = [
            'manage users',
            'manage events',
            'manage invitations',
            'manage guests',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $customer = Role::firstOrCreate(['name' => 'customer']);

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::all()); // Admin gets all permissions
        $customer->givePermissionTo('manage invitations'); // Customers can only manage invitations
    }
}

