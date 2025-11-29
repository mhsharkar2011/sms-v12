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

        $academicYear = '2024-2025';

        // Define classes with unique grade_level + section combinations
        $classes = [
            // Nursery to UKG - Single section
            ['name' => 'Nursery', 'code' => 'NUR', 'grade_level' => 'Nursery', 'section' => 'A'],
            ['name' => 'LKG', 'code' => 'LKG', 'grade_level' => 'LKG', 'section' => 'A'],
            ['name' => 'UKG', 'code' => 'UKG', 'grade_level' => 'UKG', 'section' => 'A'],

            // Grade 1-5 - Multiple sections
            ['name' => 'Class 1', 'code' => 'C1A', 'grade_level' => '1', 'section' => 'A'],
            ['name' => 'Class 1', 'code' => 'C1B', 'grade_level' => '1', 'section' => 'B'],
            ['name' => 'Class 1', 'code' => 'C1C', 'grade_level' => '1', 'section' => 'C'],

            ['name' => 'Class 2', 'code' => 'C2A', 'grade_level' => '2', 'section' => 'A'],
            ['name' => 'Class 2', 'code' => 'C2B', 'grade_level' => '2', 'section' => 'B'],
            ['name' => 'Class 2', 'code' => 'C2C', 'grade_level' => '2', 'section' => 'C'],

            // ['name' => 'Class 3', 'code' => 'C3A', 'grade_level' => '3', 'section' => 'A'],
            // ['name' => 'Class 3', 'code' => 'C3B', 'grade_level' => '3', 'section' => 'B'],
            // ['name' => 'Class 3', 'code' => 'C3C', 'grade_level' => '3', 'section' => 'C'],

            // ['name' => 'Class 4', 'code' => 'C4A', 'grade_level' => '4', 'section' => 'A'],
            // ['name' => 'Class 4', 'code' => 'C4B', 'grade_level' => '4', 'section' => 'B'],

            // ['name' => 'Class 5', 'code' => 'C5A', 'grade_level' => '5', 'section' => 'A'],
            // ['name' => 'Class 5', 'code' => 'C5B', 'grade_level' => '5', 'section' => 'B'],

            // Grade 6-8 - Multiple sections
            // ['name' => 'Class 6', 'code' => 'C6A', 'grade_level' => '6', 'section' => 'A'],
            // ['name' => 'Class 6', 'code' => 'C6B', 'grade_level' => '6', 'section' => 'B'],

            // ['name' => 'Class 7', 'code' => 'C7A', 'grade_level' => '7', 'section' => 'A'],
            // ['name' => 'Class 7', 'code' => 'C7B', 'grade_level' => '7', 'section' => 'B'],

            // ['name' => 'Class 8', 'code' => 'C8A', 'grade_level' => '8', 'section' => 'A'],
            // ['name' => 'Class 8', 'code' => 'C8B', 'grade_level' => '8', 'section' => 'B'],

            // Grade 9-10 - Single section
            // ['name' => 'Class 9', 'code' => 'C9', 'grade_level' => '9', 'section' => 'A'],
            // ['name' => 'Class 10', 'code' => 'C10', 'grade_level' => '10', 'section' => 'A'],

            // // Grade 11-12 - Different streams with different sections to avoid conflicts
            // ['name' => 'Class 11 Science', 'code' => 'C11S', 'grade_level' => '11', 'section' => 'A'],
            // ['name' => 'Class 11 Commerce', 'code' => 'C11C', 'grade_level' => '11', 'section' => 'B'], // Changed to B
            // ['name' => 'Class 11 Arts', 'code' => 'C11A', 'grade_level' => '11', 'section' => 'C'],     // Changed to C

            // ['name' => 'Class 12 Science', 'code' => 'C12S', 'grade_level' => '12', 'section' => 'A'],
            // ['name' => 'Class 12 Commerce', 'code' => 'C12C', 'grade_level' => '12', 'section' => 'B'], // Changed to B
            // ['name' => 'Class 12 Arts', 'code' => 'C12A', 'grade_level' => '12', 'section' => 'C'],     // Changed to C
        ];

        $createdCount = 0;

        foreach ($classes as $classData) {
            // Check if this combination already exists to avoid duplicates
            $exists = SchoolClass::where('grade_level', $classData['grade_level'])
                ->where('section', $classData['section'])
                ->where('academic_year', $academicYear)
                ->exists();

            if ($exists) {
                $this->command->warn("Class already exists: Grade {$classData['grade_level']}, Section {$classData['section']}");
                continue;
            }

            SchoolClass::create([
                'name' => $classData['name'],
                'code' => $classData['code'],
                'grade_level' => $classData['grade_level'],
                'section' => $classData['section'],
                'class_teacher_id' => null,
                'capacity' => $this->getCapacity($classData['grade_level']),
                'current_strength' => 0,
                'room_number' => $this->generateRoomNumber($classData['grade_level'], $classData['section']),
                'description' => $classData['name'] . ' - Academic Year ' . $academicYear,
                'status' => 'active',
                'academic_year' => $academicYear,
            ]);

            $createdCount++;
            $this->command->info("Created class: {$classData['name']} - Section {$classData['section']}");
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
