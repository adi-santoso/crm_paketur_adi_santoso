<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $superAdminPermission = [
            [
                'name' => 'CompanyController.read',
                'guard_name' => 'api'
            ],
            [
                'name' => 'CompanyController.create',
                'guard_name' => 'api'
            ],
            [
                'name' => 'CompanyController.show',
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

            [
                'name' => 'EmployeeController.read',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.create',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.show',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.update',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.delete',
                'guard_name' => 'api'
            ],
        ];


        $managerPermission = [
            [
                'name' => 'EmployeeController.read',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.create',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.show',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.update',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.delete',
                'guard_name' => 'api'
            ],
        ];


        $employeePermission = [
            [
                'name' => 'EmployeeController.read',
                'guard_name' => 'api'
            ],
            [
                'name' => 'EmployeeController.show',
                'guard_name' => 'api'
            ],
        ];

        Permission::query()
            ->upsert(
                $superAdminPermission,
                ['name'],
                ['guard_name']
            );

        $permissions = Permission::all();
        $roleSuperAdmin = Role::create(['name' => 'super_admin', 'guard_name' => 'api']);
        if ($roleSuperAdmin) {
            $roleSuperAdmin->syncPermissions($permissions);

            $this->command->info('Permissions synced with the super_admin role.');
        } else {
            $this->command->error('Role "super_admin" not found. Please create the role first.');
        }

        $roleManager = Role::create(['name' => 'manager', 'guard_name' => 'api']);

        if ($roleManager) {
            $roleManager->givePermissionTo(array_column($managerPermission, 'name'));

            $this->command->info('Permissions synced with the manager role.');
        } else {
            $this->command->error('Role "manager" not found. Please create the role first.');
        }

        $roleEmployee =Role::create(['name' => 'employee', 'guard_name' => 'api']);

        if ($roleEmployee) {
            $roleManager->givePermissionTo(array_column($employeePermission, 'name'));

            $this->command->info('Permissions synced with the employee role.');
        } else {
            $this->command->error('Role "employee" not found. Please create the role first.');
        }

    }
}
