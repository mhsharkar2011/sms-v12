<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing classes to avoid conflicts
        SchoolClass::query()->delete();

        // Define classes with unique grade_level + section combinations
        // Set academic_year to the current year or a specific year
        $currentYear = date('Y');
        $classes = [
            // Nursery to UKG - Single section
            ['name' => 'Nursery', 'code' => 'NUR', 'grade_level' => 'Nursery', 'section' => 'A', 'academic_year' => $currentYear],
            ['name' => 'LKG', 'code' => 'LKG', 'grade_level' => 'LKG', 'section' => 'A', 'academic_year' => $currentYear],
            ['name' => 'UKG', 'code' => 'UKG', 'grade_level' => 'UKG', 'section' => 'A', 'academic_year' => $currentYear],

            // Grade 1-5 - Multiple sections
            ['name' => 'Class 1', 'code' => 'C1A', 'grade_level' => '1', 'section' => 'A', 'academic_year' => $currentYear],
            ['name' => 'Class 1', 'code' => 'C1B', 'grade_level' => '1', 'section' => 'B', 'academic_year' => $currentYear],
            ['name' => 'Class 1', 'code' => 'C1C', 'grade_level' => '1', 'section' => 'C', 'academic_year' => $currentYear],

            ['name' => 'Class 2', 'code' => 'C2A', 'grade_level' => '2', 'section' => 'A', 'academic_year' => $currentYear],
            ['name' => 'Class 2', 'code' => 'C2B', 'grade_level' => '2', 'section' => 'B', 'academic_year' => $currentYear],
            ['name' => 'Class 2', 'code' => 'C2C', 'grade_level' => '2', 'section' => 'C', 'academic_year' => $currentYear],
        ];

        $createdCount = 0;

        foreach ($classes as $classData) {
            // Check if this combination already exists to avoid duplicates
            $exists = SchoolClass::where('grade_level', $classData['grade_level'])
                ->where('section', $classData['section'])
                ->where('academic_year', $classData['academic_year'])
                ->exists();

            if ($exists) {
                $this->command->warn("Class already exists: Grade {$classData['grade_level']}, Section {$classData['section']}, Year {$classData['academic_year']}");
                continue;
            }

            SchoolClass::create([
                'name' => $classData['name'],
                'code' => $classData['code'],
                'grade_level' => $classData['grade_level'],
                'section' => $classData['section'],
                'academic_year' => $classData['academic_year'], // Make sure this is included
                'capacity' => $this->getCapacity($classData['grade_level']),
                'current_strength' => 0,
                'room_number' => $this->generateRoomNumber($classData['grade_level'], $classData['section']),
                'description' => $classData['name'],
                'status' => 'active',
            ]);

            $createdCount++;
            $this->command->info("Created class: {$classData['name']} - Section {$classData['section']} - Year {$classData['academic_year']}");
        }

        $this->command->info("School classes seeded successfully! Created {$createdCount} classes.");
    }

    /**
     * Get capacity based on grade level
     */
    private function getCapacity($gradeLevel): int
    {
        return match ($gradeLevel) {
            'Nursery', 'LKG', 'UKG' => 25,
            '1', '2', '3' => 35,
            '4', '5', '6', '7', '8' => 40,
            '9', '10' => 45,
            '11', '12' => 35,
            default => 40
        };
    }

    /**
     * Generate room number based on grade level and section
     */
    private function generateRoomNumber($gradeLevel, $section): string
    {
        $baseRoom = match ($gradeLevel) {
            'Nursery', 'LKG', 'UKG' => 101,
            '1', '2', '3' => 201,
            '4', '5', '6' => 301,
            '7', '8' => 401,
            '9', '10' => 501,
            '11', '12' => 601,
            default => 101
        };

        $sectionOffset = ord($section) - ord('A');
        return 'R' . ($baseRoom + $sectionOffset);
    }
}
