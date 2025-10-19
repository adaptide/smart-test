<?php

namespace Database\Seeders;

use App\Enums\User\Permission as UserPermission;
use App\Enums\User\Role as UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{

    public function run(): void
    {
        $data = [
            UserRole::manager()->value => [
                UserPermission::viewTickets()->value,
                UserPermission::manageTickets()->value,
                UserPermission::viewCustomers()->value,
            ],
        ];

        foreach ($data as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
                $role->givePermissionTo($permission);
            }
        }

        $user = User::create([
            'name' => 'Manager User',
            'email' => 'manager@smart.kz',
            'password' => bcrypt('asdasdasd'),
        ]);
        $user->assignRole(UserRole::manager()->value);
    }
}
