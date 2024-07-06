<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SettingSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        // Seed super admin
        $user = User::create([
            'username' => 'superadmin',
            'email' => 'ngotuananh2101@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'is_active' => true,
            'google_id' => '114944751449340400280',
        ]);
        $user->syncRoles('super-admin');
        User::factory(29)->create();
    }
}
