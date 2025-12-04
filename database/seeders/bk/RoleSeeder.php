<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'System administrator with full access',
                'is_default' => false,
            ],
            [
                'name' => 'Teacher',
                'slug' => 'teacher',
                'description' => 'Teaching staff with course management access',
                'is_default' => false,
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
                'description' => 'Student with learning access',
                'is_default' => true,
            ],
            [
                'name' => 'Parent',
                'slug' => 'parent',
                'description' => 'Parent with student monitoring access',
                'is_default' => false,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
