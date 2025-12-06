<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
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

        // Step 4: Assign Roles to Users (will be done in UserSeeder)
        $this->command->info('✅ Permissions and Roles seeded successfully!');
        $this->command->info("Created " . count($permissions) . " permissions");
        $this->command->info("Created " . count($roles) . " roles");
    }

    /**
     * Create all permissions for the school system
     */
    private function createPermissions(): array
    {
        $permissionGroups = [
            // Dashboard & General
            'dashboard' => [
                'view_dashboard',
                'view_statistics',
                'export_data',
            ],

            // User Management
            'users' => [
                'view_users',
                'create_users',
                'edit_users',
                'delete_users',
                'activate_users',
                'deactivate_users',
                'view_user_profiles',
                'edit_user_profiles',
                'assign_user_roles',
            ],

            // Role & Permission Management
            'roles' => [
                'view_roles',
                'create_roles',
                'edit_roles',
                'delete_roles',
                'assign_permissions',
            ],

            // Department Management
            'departments' => [
                'view_departments',
                'create_departments',
                'edit_departments',
                'delete_departments',
                'assign_department_head',
            ],

            // Student Management
            'students' => [
                'view_students',
                'create_students',
                'edit_students',
                'delete_students',
                'view_student_details',
                'assign_student_class',
                'transfer_student',
                'promote_student',
                'view_student_family',
            ],

            // Teacher Management
            'teachers' => [
                'view_teachers',
                'create_teachers',
                'edit_teachers',
                'delete_teachers',
                'assign_teacher_subjects',
                'assign_class_teacher',
                'view_teacher_schedule',
            ],

            // Class Management
            'classes' => [
                'view_classes',
                'create_classes',
                'edit_classes',
                'delete_classes',
                'view_class_details',
                'manage_class_students',
                'manage_class_schedule',
                'assign_class_teacher',
                'view_class_timetable',
            ],

            // Subject Management
            'subjects' => [
                'view_subjects',
                'create_subjects',
                'edit_subjects',
                'delete_subjects',
                'assign_subject_teacher',
                'view_subject_syllabus',
            ],

            // Attendance Management
            'attendance' => [
                'view_attendance',
                'take_attendance',
                'edit_attendance',
                'delete_attendance',
                'view_attendance_reports',
                'export_attendance',
                'manage_attendance_settings',
            ],

            // Exam & Grade Management
            'exams' => [
                'view_exams',
                'create_exams',
                'edit_exams',
                'delete_exams',
                'schedule_exams',
                'manage_exam_rooms',
            ],

            'grades' => [
                'view_grades',
                'add_grades',
                'edit_grades',
                'delete_grades',
                'publish_grades',
                'view_grade_reports',
                'generate_report_cards',
                'calculate_gpa',
            ],

            // Fee Management
            'fees' => [
                'view_fees',
                'create_fees',
                'edit_fees',
                'delete_fees',
                'collect_fees',
                'view_fee_reports',
                'generate_fee_receipts',
                'manage_fee_discounts',
                'view_fee_arrears',
            ],

            // Library Management
            'library' => [
                'view_books',
                'add_books',
                'edit_books',
                'delete_books',
                'issue_books',
                'return_books',
                'view_issued_books',
                'manage_categories',
                'view_library_reports',
            ],

            // Inventory Management
            'inventory' => [
                'view_inventory',
                'add_items',
                'edit_items',
                'delete_items',
                'issue_items',
                'view_stock',
                'generate_inventory_reports',
            ],

            // Transportation
            'transport' => [
                'view_vehicles',
                'add_vehicles',
                'edit_vehicles',
                'delete_vehicles',
                'assign_routes',
                'view_transport_reports',
                'manage_drivers',
            ],

            // Hostel Management
            'hostel' => [
                'view_hostels',
                'manage_hostels',
                'assign_rooms',
                'view_hostel_occupancy',
                'manage_hostel_fees',
            ],

            // Notice & Announcement
            'notices' => [
                'view_notices',
                'create_notices',
                'edit_notices',
                'delete_notices',
                'publish_notices',
                'send_notifications',
            ],

            // Posts & Content
            'posts' => [
                'view_posts',
                'create_posts',
                'edit_posts',
                'delete_posts',
                'publish_posts',
                'approve_posts',
                'view_all_posts',
            ],

            'comments' => [
                'view_comments',
                'create_comments',
                'edit_comments',
                'delete_comments',
                'approve_comments',
                'manage_comments',
            ],

            // Settings
            'settings' => [
                'view_settings',
                'edit_settings',
                'manage_academic_year',
                'manage_school_info',
                'manage_session',
                'manage_holidays',
                'manage_sms_templates',
                'manage_email_templates',
            ],

            // Reports
            'reports' => [
                'view_all_reports',
                'generate_reports',
                'export_reports',
                'view_financial_reports',
                'view_academic_reports',
                'view_student_reports',
                'view_teacher_reports',
            ],
        ];

        $createdPermissions = [];
        foreach ($permissionGroups as $group => $groupPermissions) {
            foreach ($groupPermissions as $permission) {
                $perm = Permission::create([
                    'name' => $permission,
                    'group' => $group,
                    'guard_name' => 'web',
                ]);
                $createdPermissions[$permission] = $perm;
            }
        }

        return $createdPermissions;
    }

    /**
     * Create roles for the school system
     */
    private function createRoles(): array
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Administrator',
                'description' => 'Has full control over the entire system',
                'color' => '#dc3545',
                'level' => 100,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Can manage most aspects of the system',
                'color' => '#0d6efd',
                'level' => 90,
            ],
            [
                'name' => 'principal',
                'display_name' => 'Principal',
                'description' => 'School principal with administrative rights',
                'color' => '#198754',
                'level' => 80,
            ],
            [
                'name' => 'vice_principal',
                'display_name' => 'Vice Principal',
                'description' => 'Assists principal in school administration',
                'color' => '#20c997',
                'level' => 75,
            ],
            [
                'name' => 'head_teacher',
                'display_name' => 'Head Teacher',
                'description' => 'Head of teaching department',
                'color' => '#6f42c1',
                'level' => 70,
            ],
            [
                'name' => 'teacher',
                'display_name' => 'Teacher',
                'description' => 'Regular teaching staff',
                'color' => '#fd7e14',
                'level' => 50,
            ],
            [
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'School student',
                'color' => '#6c757d',
                'level' => 30,
            ],
            [
                'name' => 'parent',
                'display_name' => 'Parent',
                'description' => 'Parent/Guardian of student',
                'color' => '#7952b3',
                'level' => 20,
            ],
            [
                'name' => 'accountant',
                'display_name' => 'Accountant',
                'description' => 'Manages financial transactions',
                'color' => '#d63384',
                'level' => 60,
            ],
            [
                'name' => 'librarian',
                'display_name' => 'Librarian',
                'description' => 'Manages library operations',
                'color' => '#0dcaf0',
                'level' => 55,
            ],
            [
                'name' => 'receptionist',
                'display_name' => 'Receptionist',
                'description' => 'Front desk and administrative support',
                'color' => '#ffc107',
                'level' => 40,
            ],
            [
                'name' => 'driver',
                'display_name' => 'Driver',
                'description' => 'School transport driver',
                'color' => '#6610f2',
                'level' => 10,
            ],
        ];

        $createdRoles = [];
        foreach ($roles as $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'guard_name' => 'web',
            ]);

            // Store additional data in custom fields (you might want to extend the Role model)
            DB::table('roles')->where('id', $role->id)->update([
                'display_name' => $roleData['display_name'],
                'description' => $roleData['description'],
            ]);

            $createdRoles[$roleData['name']] = $role;
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

        // Admin - Most permissions except sensitive ones
        $adminPermissions = [
            // Dashboard
            'view_dashboard', 'view_statistics', 'export_data',

            // Users
            'view_users', 'create_users', 'edit_users', 'activate_users', 'deactivate_users',
            'view_user_profiles', 'edit_user_profiles',

            // Departments
            'view_departments', 'create_departments', 'edit_departments',

            // Students
            'view_students', 'create_students', 'edit_students', 'view_student_details',
            'assign_student_class', 'transfer_student', 'promote_student',

            // Teachers
            'view_teachers', 'create_teachers', 'edit_teachers', 'assign_teacher_subjects',
            'assign_class_teacher',

            // Classes
            'view_classes', 'create_classes', 'edit_classes', 'view_class_details',
            'manage_class_students', 'manage_class_schedule', 'assign_class_teacher',

            // Subjects
            'view_subjects', 'create_subjects', 'edit_subjects', 'assign_subject_teacher',

            // Attendance
            'view_attendance', 'take_attendance', 'edit_attendance', 'view_attendance_reports',
            'export_attendance',

            // Exams & Grades
            'view_exams', 'create_exams', 'edit_exams', 'schedule_exams',
            'view_grades', 'add_grades', 'edit_grades', 'publish_grades', 'view_grade_reports',
            'generate_report_cards',

            // Fees
            'view_fees', 'create_fees', 'edit_fees', 'collect_fees', 'view_fee_reports',
            'generate_fee_receipts', 'manage_fee_discounts',

            // Library
            'view_books', 'add_books', 'edit_books', 'issue_books', 'return_books',

            // Notices
            'view_notices', 'create_notices', 'edit_notices', 'publish_notices',

            // Posts
            'view_posts', 'create_posts', 'edit_posts', 'delete_posts', 'publish_posts',

            // Settings
            'view_settings', 'edit_settings', 'manage_academic_year', 'manage_school_info',
            'manage_session', 'manage_holidays',

            // Reports
            'view_all_reports', 'generate_reports', 'export_reports',
        ];
        $roles['admin']->syncPermissions($adminPermissions);

        // Principal
        $principalPermissions = [
            'view_dashboard', 'view_statistics',
            'view_users', 'view_user_profiles',
            'view_departments',
            'view_students', 'view_student_details', 'view_student_family',
            'view_teachers', 'view_teacher_schedule',
            'view_classes', 'view_class_details', 'view_class_timetable',
            'view_subjects',
            'view_attendance', 'view_attendance_reports',
            'view_exams', 'view_grades', 'view_grade_reports', 'generate_report_cards',
            'view_fees', 'view_fee_reports',
            'view_notices', 'create_notices', 'edit_notices', 'publish_notices',
            'view_posts', 'create_posts', 'edit_posts',
            'view_settings', 'manage_academic_year', 'manage_session',
            'view_all_reports', 'generate_reports',
        ];
        $roles['principal']->syncPermissions($principalPermissions);

        // Teacher
        $teacherPermissions = [
            'view_dashboard',
            'view_user_profiles',
            'view_students', 'view_student_details',
            'view_classes', 'view_class_details', 'view_class_timetable',
            'view_subjects', 'view_subject_syllabus',
            'view_attendance', 'take_attendance', 'edit_attendance',
            'view_exams',
            'view_grades', 'add_grades', 'edit_grades',
            'view_posts', 'create_posts', 'edit_posts', 'delete_posts',
            'view_comments', 'create_comments', 'edit_comments', 'delete_comments',
        ];
        $roles['teacher']->syncPermissions($teacherPermissions);

        // Student
        $studentPermissions = [
            'view_dashboard',
            'view_user_profiles',
            'view_classes',
            'view_subjects',
            'view_attendance',
            'view_exams',
            'view_grades',
            'view_posts', 'create_posts', 'edit_posts', 'delete_posts',
            'view_comments', 'create_comments', 'edit_comments', 'delete_comments',
        ];
        $roles['student']->syncPermissions($studentPermissions);

        // Parent
        $parentPermissions = [
            'view_dashboard',
            'view_student_details',
            'view_attendance',
            'view_grades',
            'view_fees',
            'view_notices',
        ];
        $roles['parent']->syncPermissions($parentPermissions);

        // Accountant
        $accountantPermissions = [
            'view_dashboard',
            'view_users',
            'view_students',
            'view_fees', 'create_fees', 'edit_fees', 'collect_fees', 'view_fee_reports',
            'generate_fee_receipts', 'manage_fee_discounts', 'view_fee_arrears',
            'view_financial_reports',
        ];
        $roles['accountant']->syncPermissions($accountantPermissions);

        // Librarian
        $librarianPermissions = [
            'view_dashboard',
            'view_books', 'add_books', 'edit_books', 'delete_books', 'issue_books',
            'return_books', 'view_issued_books', 'manage_categories', 'view_library_reports',
        ];
        $roles['librarian']->syncPermissions($librarianPermissions);

        $this->command->info('✅ Permissions assigned to roles successfully!');
    }
}
