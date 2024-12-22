<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah role Super Admin sudah ada
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // Tambahkan user Super Admin
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Assign role Super Admin ke user
        $user->assignRole($superAdminRole);
    }
}
