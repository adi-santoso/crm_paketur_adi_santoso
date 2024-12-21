<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::query()
            ->upsert(
                [
                    [
                        'name' => 'CompanyController.read',
                        'guard_name' => 'api'
                    ],
                    [
                        'name' => 'CompanyController.create',
                        'guard_name' => 'api'
                    ],
                    [
                        'name' => 'CompanyController.update',
                        'guard_name' => 'api'
                    ],
                    [
                        'name' => 'CompanyController.delete',
                        'guard_name' => 'api'
                    ],
                ]
                ['name'],
                ['guard_name']
            );
    }
}
