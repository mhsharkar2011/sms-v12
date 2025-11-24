<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        // Admin gets all permissions
        $adminRole = Role::where('slug', 'admin')->first();
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));

        // Teacher permissions
        $teacherRole = Role::where('slug', 'teacher')->first();
        $teacherPermissions = Permission::whereIn('slug', [
            'view-courses',
            'create-courses',
            'manage-assignments',
            'grade-submissions',
            'manage-attendance',
            'view-student-profiles'
        ])->get();
        $teacherRole->permissions()->sync($teacherPermissions->pluck('id'));

        // Student permissions
        $studentRole = Role::where('slug', 'student')->first();
        $studentPermissions = Permission::whereIn('slug', [
            'view-courses',
            'submit-assignments',
            'view-grades',
            'view-attendance'
        ])->get();
        $studentRole->permissions()->sync($studentPermissions->pluck('id'));

        // Parent permissions
        $parentRole = Role::where('slug', 'parent')->first();
        $parentPermissions = Permission::whereIn('slug', [
            'view-child-grades',
            'view-child-attendance',
            'communicate-teachers'
        ])->get();
        $parentRole->permissions()->sync($parentPermissions->pluck('id'));
    }
}
