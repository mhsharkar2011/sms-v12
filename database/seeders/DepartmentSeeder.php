<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Mathematics', 'code' => 'MATH'],
            ['name' => 'Science', 'code' => 'SCI'],
            ['name' => 'English', 'code' => 'ENG'],
            ['name' => 'Social Studies', 'code' => 'SOC'],
            ['name' => 'Computer Science', 'code' => 'CS'],
            ['name' => 'Physical Education', 'code' => 'PE'],
            ['name' => 'Arts', 'code' => 'ART'],
            ['name' => 'Music', 'code' => 'MUS'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
