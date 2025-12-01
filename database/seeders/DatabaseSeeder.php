<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Guard;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
        ]);

        $this->call([
            RolePermissionSeeder::class,
            TeacherSubjectSeeder::class,
            SchoolClassSeeder::class,
            StudentSeeder::class,
            GuardianSeeder::class,
            DepartmentSeeder::class,
            // TeacherSeeder::class,
            // SubjectSeeder::class,
            // AcademicYearSeeder::class,
            // ClassScheduleSeeder::class,
            // AttendanceSeeder::class,
            // GradeSeeder::class,
            // ExamSeeder::class,
            // ExamResultSeeder::class,
            // StudentAddressSeeder::class,
        ]);
    }
}
