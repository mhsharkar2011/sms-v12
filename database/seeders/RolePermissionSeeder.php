<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Step 1: Create Permissions
        $permissions = $this->createPermissions();

        // Step 2: Create Roles
        $roles = $this->createRoles();

        // Step 3: Assign Permissions to Roles
        $this->assignPermissionsToRoles($permissions, $roles);

        $this->command->info('✅ Roles and Permissions seeded successfully!');
        $this->command->info("Created " . count($permissions) . " permissions");
        $this->command->info("Created " . count($roles) . " roles");
    }

    /**
     * Create all permissions for the school system
     */
    private function createPermissions(): array
    {
        $permissions = [
            // Dashboard & General
            'view_dashboard',
            'view_statistics',
            'export_data',

            // User Management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'activate_users',
            'deactivate_users',

            // Role & Permission Management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',

            // Department Management
            'view_departments',
            'create_departments',
            'edit_departments',
            'delete_departments',

            // Student Management
            'view_students',
            'create_students',
            'edit_students',
            'delete_students',
            'assign_student_class',
            'view_student_grades',

            // Teacher Management
            'view_teachers',
            'create_teachers',
            'edit_teachers',
            'delete_teachers',
            'assign_teacher_subjects',

            // Class Management
            'view_classes',
            'create_classes',
            'edit_classes',
            'delete_classes',
            'manage_class_schedule',

            // Subject Management
            'view_subjects',
            'create_subjects',
            'edit_subjects',
            'delete_subjects',

            // Attendance Management
            'view_attendance',
            'take_attendance',
            'edit_attendance',

            // Exam & Grade Management
            'view_exams',
            'create_exams',
            'edit_exams',
            'view_grades',
            'add_grades',
            'edit_grades',
            'publish_grades',

            // Fee Management
            'view_fees',
            'create_fees',
            'edit_fees',
            'collect_fees',
            'view_fee_reports',

            // Posts & Comments
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'publish_posts',
            'view_comments',
            'create_comments',
            'edit_comments',
            'delete_comments',

            // Settings
            'view_settings',
            'edit_settings',
        ];

        $createdPermissions = [];
        foreach ($permissions as $permissionName) {
            $perm = Permission::create([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
            $createdPermissions[$permissionName] = $perm;
        }

        return $createdPermissions;
    }

    /**
     * Create roles for the school system
     */
    private function createRoles(): array
    {
        $roleNames = [
            'super_admin',
            'admin',
            'teacher',
            'student',
            'parent',
            'accountant',
        ];

        $createdRoles = [];
        foreach ($roleNames as $roleName) {
            $role = Role::create([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $createdRoles[$roleName] = $role;
        }

        return $createdRoles;
    }

    /**
     * Assign permissions to roles
     */
    private function assignPermissionsToRoles(array $permissions, array $roles): void
    {
        // Super Admin - All permissions
        $roles['super_admin']->syncPermissions(array_values($permissions));

        // Admin - Most permissions
        $adminPermissions = [
            'view_dashboard',
            'view_statistics',
            'export_data',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'activate_users',
            'deactivate_users',
            'view_departments',
            'create_departments',
            'edit_departments',
            'delete_departments',
            'view_students',
            'create_students',
            'edit_students',
            'delete_students',
            'assign_student_class',
            'view_student_grades',
            'view_teachers',
            'create_teachers',
            'edit_teachers',
            'delete_teachers',
            'view_classes',
            'create_classes',
            'edit_classes',
            'delete_classes',
            'manage_class_schedule',
            'view_subjects',
            'create_subjects',
            'edit_subjects',
            'delete_subjects',
            'view_attendance',
            'take_attendance',
            'edit_attendance',
            'view_exams',
            'create_exams',
            'edit_exams',
            'view_grades',
            'add_grades',
            'edit_grades',
            'publish_grades',
            'view_fees',
            'create_fees',
            'edit_fees',
            'collect_fees',
            'view_fee_reports',
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'publish_posts',
            'view_settings',
            'edit_settings',
        ];
        $roles['admin']->syncPermissions($adminPermissions);

        // Teacher
        $teacherPermissions = [
            'view_dashboard',
            'view_students',
            'view_student_grades',
            'view_classes',
            'view_subjects',
            'view_attendance',
            'take_attendance',
            'edit_attendance',
            'view_grades',
            'add_grades',
            'edit_grades',
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'view_comments',
            'create_comments',
            'edit_comments',
            'delete_comments',
        ];
        $roles['teacher']->syncPermissions($teacherPermissions);

        // Student
        $studentPermissions = [
            'view_dashboard',
            'view_student_grades',
            'view_attendance',
            'view_grades',
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'view_comments',
            'create_comments',
            'edit_comments',
            'delete_comments',
        ];
        $roles['student']->syncPermissions($studentPermissions);

        // Parent
        $parentPermissions = [
            'view_dashboard',
            'view_student_grades',
            'view_attendance',
            'view_grades',
            'view_fees',
            'view_fee_reports',
        ];
        $roles['parent']->syncPermissions($parentPermissions);

        // Accountant
        $accountantPermissions = [
            'view_dashboard',
            'view_students',
            'view_fees',
            'create_fees',
            'edit_fees',
            'collect_fees',
            'view_fee_reports',
        ];
        $roles['accountant']->syncPermissions($accountantPermissions);

        $this->command->info('✅ Permissions assigned to roles successfully!');
    }
}
