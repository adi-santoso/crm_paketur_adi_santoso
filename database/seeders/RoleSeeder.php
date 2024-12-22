<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'super_admin', 'guard_name' => 'api']);
        Role::create(['name' => 'manager', 'guard_name' => 'api']);
        Role::create(['name' => 'employee', 'guard_name' => 'api']);
    }
}
