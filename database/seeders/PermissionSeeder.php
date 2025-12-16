<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles & permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            // Users
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            // Roles
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',

            // Permissions
            'view_permissions',
            'create_permissions',
            'edit_permissions',
            'delete_permissions',

            // category
             'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        // Admin → all permissions
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions(Permission::all());

        // Editor → limited permissions
        $editor = Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'web',
        ]);

        $editor->syncPermissions([
            'view_users',
            'create_users',
            'edit_users',
            'view_roles',
        ]);

        // Employee → read-only
        $employee = Role::firstOrCreate([
            'name' => 'employee',
            'guard_name' => 'web',
        ]);

        $employee->syncPermissions([
            'view_users',
        ]);
    }
}
