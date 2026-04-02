<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions if needed
        // Example: Permission::create(['name' => 'edit articles']);

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $lawyer = Role::create(['name' => 'lawyer']);
        $customer = Role::create(['name' => 'customer']);

        // Assign permissions to roles as needed
        // $admin->givePermissionTo('edit articles');
    }
}