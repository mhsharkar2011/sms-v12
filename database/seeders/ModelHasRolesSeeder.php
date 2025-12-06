<?php
// database/seeders/ModelHasRolesSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing role assignments
        DB::table('model_has_roles')->truncate();

        // Get roles
        $roles = Role::all()->keyBy('name');

        // First, ensure we have some users
        $this->createUsersIfNeeded();

        // Get all users
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found! Please run UserSeeder first.');
            return;
        }

        $assignments = [
            // Super Admin
            ['email' => 'superadmin@school.test', 'roles' => ['super_admin']],

            // Admin
            ['email' => 'admin@school.test', 'roles' => ['admin']],

            // Teachers
            ['email' => 'teacher1@school.test', 'roles' => ['teacher']],
            ['email' => 'teacher2@school.test', 'roles' => ['teacher']],
            ['email' => 'teacher3@school.test', 'roles' => ['teacher']],

            // Students
            ['email' => 'student1@school.test', 'roles' => ['student']],
            ['email' => 'student2@school.test', 'roles' => ['student']],
            ['email' => 'student3@school.test', 'roles' => ['student']],
            ['email' => 'student4@school.test', 'roles' => ['student']],
            ['email' => 'student5@school.test', 'roles' => ['student']],

            // Parents
            ['email' => 'parent1@school.test', 'roles' => ['parent']],
            ['email' => 'parent2@school.test', 'roles' => ['parent']],

            // Accountant
            ['email' => 'accountant@school.test', 'roles' => ['accountant']],
        ];

        $assignedCount = 0;
        foreach ($assignments as $assignment) {
            $user = User::where('email', $assignment['email'])->first();

            if ($user) {
                // Clear existing roles
                $user->roles()->detach();

                // Assign new roles
                foreach ($assignment['roles'] as $roleName) {
                    if (isset($roles[$roleName])) {
                        $user->assignRole($roles[$roleName]);
                        $assignedCount++;
                    }
                }

                $this->command->info("✓ Assigned roles to: {$user->email} (" . implode(', ', $assignment['roles']) . ")");
            } else {
                $this->command->warn("User not found: {$assignment['email']}");
            }
        }

        // Assign default roles to remaining users based on type
        foreach ($users as $user) {
            if ($user->roles->isEmpty()) {
                // Assign default role based on user type
                $defaultRole = match ($user->type ?? 'student') {
                    'admin' => 'admin',
                    'teacher' => 'teacher',
                    'student' => 'student',
                    'parent' => 'parent',
                    'accountant' => 'accountant',
                    default => 'student',
                };

                if (isset($roles[$defaultRole])) {
                    $user->assignRole($roles[$defaultRole]);
                    $assignedCount++;
                    $this->command->info("✓ Assigned default role {$defaultRole} to: {$user->email}");
                }
            }
        }

        $this->command->info("✅ Total role assignments: {$assignedCount}");
        $this->command->info("Total users with roles: " . User::has('roles')->count());

        // Show summary
        $this->showRoleAssignmentSummary();
    }

    /**
     * Create sample users if they don't exist
     */
    private function createUsersIfNeeded(): void
    {
        $users = [
            // Super Admin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@school.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Admin
            [
                'name' => 'School Admin',
                'email' => 'admin@school.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Teachers
            [
                'name' => 'Math Teacher',
                'email' => 'teacher1@school.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Science Teacher',
                'email' => 'teacher2@school.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'English Teacher',
                'email' => 'teacher3@school.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Students
            [
                'name' => 'Student One',
                'email' => 'student1@school.test',
                'password' => Hash::make('password'),

                'email_verified_at' => now(),
            ],
            [
                'name' => 'Student Two',
                'email' => 'student2@school.test',
                'password' => Hash::make('password'),

                'email_verified_at' => now(),
            ],
            [
                'name' => 'Student Three',
                'email' => 'student3@school.test',
                'password' => Hash::make('password'),

                'email_verified_at' => now(),
            ],
            [
                'name' => 'Student Four',
                'email' => 'student4@school.test',
                'password' => Hash::make('password'),

                'email_verified_at' => now(),
            ],
            [
                'name' => 'Student Five',
                'email' => 'student5@school.test',
                'password' => Hash::make('password'),

                'email_verified_at' => now(),
            ],

            // Parents
            [
                'name' => 'Parent One',
                'email' => 'parent1@school.test',
                'password' => Hash::make('password'),

                'email_verified_at' => now(),
            ],
            [
                'name' => 'Parent Two',
                'email' => 'parent2@school.test',
                'password' => Hash::make('password'),

                'email_verified_at' => now(),
            ],

            // Accountant
            [
                'name' => 'School Accountant',
                'email' => 'accountant@school.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Created sample users for role assignments');
    }

    /**
     * Show role assignment summary
     */
    private function showRoleAssignmentSummary(): void
    {
        $summary = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name as role_name', DB::raw('COUNT(*) as user_count'))
            ->groupBy('roles.name')
            ->orderBy('user_count', 'desc')
            ->get();

        $this->command->info("\n📊 Role Assignment Summary:");
        $this->command->info("==========================");
        foreach ($summary as $row) {
            $this->command->info("{$row->role_name}: {$row->user_count} users");
        }
        $this->command->info("==========================");

        // Show some examples of what was inserted into model_has_roles
        $sampleAssignments = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->where('model_has_roles.model_type', User::class)
            ->select('users.email', 'users.name', 'roles.name as role_name')
            ->limit(5)
            ->get();

        $this->command->info("\n👥 Sample Role Assignments:");
        foreach ($sampleAssignments as $assignment) {
            $this->command->info("{$assignment->name} ({$assignment->email}) → {$assignment->role_name}");
        }
    }
}
