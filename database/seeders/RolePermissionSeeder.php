<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Student permissions
            ['name' => 'view courses'],
            ['name' => 'submit assignments'],
            ['name' => 'view grades'],
            ['name' => 'view attendance'],

            // Teacher permissions
            ['name' => 'create courses'],
            ['name' => 'manage assignments'],
            ['name' => 'grade submissions'],
            ['name' => 'manage attendance'],
            ['name' => 'view student profiles'],

            // Parent permissions
            ['name' => 'view child grades'],
            ['name' => 'view child attendance'],
            ['name' => 'communicate with teachers'],

            // Admin permissions
            ['name' => 'manage users'],
            ['name' => 'manage roles'],
            ['name' => 'manage permissions'],
            ['name' => 'system configuration'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole = Role::create(['name' => 'teacher']);
        $teacherRole->givePermissionTo([
            'view courses',
            'create courses',
            'manage assignments',
            'grade submissions',
            'manage attendance',
            'view student profiles'
        ]);

        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo([
            'view courses',
            'submit assignments',
            'view grades',
            'view attendance'
        ]);

        $parentRole = Role::create(['name' => 'parent']);
        $parentRole->givePermissionTo([
            'view child grades',
            'view child attendance',
            'communicate with teachers'
        ]);
    }
}
