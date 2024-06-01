<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $defaultRoleList = [
            [
                'name' => 'super-admin',
                'guard_name' => 'web',
                'is_default' => 0,
                'can_not_delete' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'is_default' => 0,
                'can_not_delete' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'user',
                'guard_name' => 'web',
                'is_default' => 1,
                'can_not_delete' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Role::insert($defaultRoleList);

        $permissions = Permission::all();

        Role::where('name', 'admin')->first()->syncPermissions($permissions);
    }
}
