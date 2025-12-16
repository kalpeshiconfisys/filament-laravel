<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin' , 'guard_name' => 'web']);

        $adminRole->syncPermissions(Permission::all());
        
        if ('admin@gmail.com' && ($user = User::where('email', 'admin@gmail.com')->first())) {
            $user->assignRole($adminRole);
        }
    }
}
