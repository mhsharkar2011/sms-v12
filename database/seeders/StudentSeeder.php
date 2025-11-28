<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'first_name' => 'Emma',
                'last_name' => 'Wilson',
                'student_id' => 'S001',
                'grade_level' => '5',
                'section' => 'A',
                'date_of_birth' => '2014-03-15',
                'gender' => 'female',
            ],
            [
                'first_name' => 'Noah',
                'last_name' => 'Wilson',
                'student_id' => 'S002',
                'grade_level' => '3',
                'section' => 'B',
                'date_of_birth' => '2016-07-22',
                'gender' => 'male',
            ],
            [
                'first_name' => 'Sophia',
                'last_name' => 'Johnson',
                'student_id' => 'S003',
                'grade_level' => '4',
                'section' => 'C',
                'date_of_birth' => '2015-11-08',
                'gender' => 'female',
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Chen',
                'student_id' => 'S004',
                'grade_level' => '6',
                'section' => 'A',
                'date_of_birth' => '2013-09-30',
                'gender' => 'male',
            ],
            [
                'first_name' => 'Olivia',
                'last_name' => 'Chen',
                'student_id' => 'S005',
                'grade_level' => '2',
                'section' => 'B',
                'date_of_birth' => '2017-12-25',
                'gender' => 'female',
            ],
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }

        // Create random students
        Student::factory()->count(15)->create();

        $this->command->info('Student seeder completed successfully!');
    }
}
