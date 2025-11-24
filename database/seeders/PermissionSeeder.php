<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Student permissions
            ['name' => 'View Courses', 'slug' => 'view-courses', 'module' => 'academic'],
            ['name' => 'Submit Assignments', 'slug' => 'submit-assignments', 'module' => 'academic'],
            ['name' => 'View Grades', 'slug' => 'view-grades', 'module' => 'academic'],
            ['name' => 'View Attendance', 'slug' => 'view-attendance', 'module' => 'academic'],

            // Teacher permissions
            ['name' => 'Create Courses', 'slug' => 'create-courses', 'module' => 'academic'],
            ['name' => 'Manage Assignments', 'slug' => 'manage-assignments', 'module' => 'academic'],
            ['name' => 'Grade Submissions', 'slug' => 'grade-submissions', 'module' => 'academic'],
            ['name' => 'Manage Attendance', 'slug' => 'manage-attendance', 'module' => 'academic'],
            ['name' => 'View Student Profiles', 'slug' => 'view-student-profiles', 'module' => 'student'],

            // Parent permissions
            ['name' => 'View Child Grades', 'slug' => 'view-child-grades', 'module' => 'academic'],
            ['name' => 'View Child Attendance', 'slug' => 'view-child-attendance', 'module' => 'academic'],
            ['name' => 'Communicate with Teachers', 'slug' => 'communicate-teachers', 'module' => 'communication'],

            // Admin permissions
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'module' => 'system'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'module' => 'system'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions', 'module' => 'system'],
            ['name' => 'System Configuration', 'slug' => 'system-config', 'module' => 'system'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
