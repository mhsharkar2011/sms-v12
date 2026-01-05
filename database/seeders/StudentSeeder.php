<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentAddress;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Get available classes for current academic year
        $academicYear = '2024-2025';
        $classes = SchoolClass::where('status', 'active')
            ->get();

        if ($classes->isEmpty()) {
            $this->command->error('No active classes found! Please run SchoolClassSeeder first.');
            return;
        }

        // Create 3 students with unique names
        $students = [
            [
                'name' => ['first_name' => 'Aarav', 'last_name' => 'Sharma'],
                'email' => 'aarav.sharma@school.com',
                'date_of_birth' => '2014-03-15',
                'gender' => 'male',
                'grade_level' => '5',
                'section' => 'A',
                'blood_group' => 'O+',
                'address' => '123 MG Road, Shivaji Nagar',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'pincode' => '411005',
                'emergency_contact_name' => 'Rajesh Sharma',
                'emergency_contact_phone' => '+91-9876543210',
                'emergency_contact_relation' => 'Father',
                'phone' => '+91-9876543201',
            ],
            [
                'name' => ['first_name' => 'Ananya', 'last_name' => 'Verma'],
                'email' => 'ananya.verma@school.com',
                'date_of_birth' => '2016-07-22',
                'gender' => 'female',
                'grade_level' => '3',
                'section' => 'B',
                'blood_group' => 'A+',
                'address' => '456 Park Street',
                'city' => 'Kolkata',
                'state' => 'West Bengal',
                'pincode' => '700016',
                'emergency_contact_name' => 'Priya Verma',
                'emergency_contact_phone' => '+91-9876543211',
                'emergency_contact_relation' => 'Mother',
                'phone' => '+91-9876543202',
            ],
            [
                'name' => ['first_name' => 'Vihaan', 'last_name' => 'Gupta'],
                'email' => 'vihaan.gupta@school.com',
                'date_of_birth' => '2015-11-08',
                'gender' => 'male',
                'grade_level' => '4',
                'section' => 'C',
                'blood_group' => 'B+',
                'address' => '789 Connaught Place',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110001',
                'emergency_contact_name' => 'Sanjay Gupta',
                'emergency_contact_phone' => '+91-9876543212',
                'emergency_contact_relation' => 'Father',
                'phone' => '+91-9876543203',
            ]
        ];

        $createdCount = 0;

        foreach ($students as $studentData) {
            // Find the class for this student based on academic year
            $class = $classes->where('grade_level', $studentData['grade_level'])
                ->where('section', $studentData['section'])
                ->where('academic_year', $academicYear) // Added academic year filter
                ->first();

            if (!$class) {
                $this->command->warn("No class found for grade: {$studentData['grade_level']}, section: {$studentData['section']}, year: {$academicYear}");
                continue;
            }

            // Generate roll number based on current strength
            $rollNumber = $class->current_strength + 1;

            // Check if student already exists
            $existingStudent = Student::where('email', $studentData['email'])
                ->orWhere(function($query) use ($studentData) {
                    $query->where('first_name', $studentData['name']['first_name'])
                          ->where('last_name', $studentData['name']['last_name']);
                })
                ->first();

            if ($existingStudent) {
                $this->command->warn("Student already exists: {$studentData['name']['first_name']} {$studentData['name']['last_name']}");
                continue;
            }

            // Create student
            $student = Student::create([
                'student_id' => $this->generateStudentId(),
                'admission_number' => $this->generateAdmissionNumber(),
                'first_name' => $studentData['name']['first_name'],
                'last_name' => $studentData['name']['last_name'],
                'email' => $studentData['email'],
                'phone' => $studentData['phone'],
                'date_of_birth' => $studentData['date_of_birth'],
                'gender' => $studentData['gender'],
                'blood_group' => $studentData['blood_group'],
                'nationality' => 'Indian',
                'religion' => $this->getRandomReligion(),
                'caste' => $this->getRandomCaste(),
                'address' => $studentData['address'],
                'city' => $studentData['city'],
                'state' => $studentData['state'],
                'pincode' => $studentData['pincode'],
                'country' => 'India',
                'emergency_contact_name' => $studentData['emergency_contact_name'],
                'emergency_contact_phone' => $studentData['emergency_contact_phone'],
                'emergency_contact_relation' => $studentData['emergency_contact_relation'],
                'admission_date' => now()->subYears(rand(1, 3))->format('Y-m-d'),
                'class_id' => $class->id,
                'grade_level' => $studentData['grade_level'],
                'roll_number' => (string) $rollNumber,
                'section' => $studentData['section'],
                'academic_year' => $academicYear,
                'medical_info' => $this->getMedicalInfo(),
                'allergies' => $this->getRandomAllergies(),
                'medications' => $this->getRandomMedications(),
                'status' => 'active',
                'is_boarder' => false,
                'uses_transport' => false,
                'father_name' => $studentData['emergency_contact_name'], // Added father name
                'mother_name' => $studentData['emergency_contact_relation'] === 'Mother' ?
                    $studentData['emergency_contact_name'] : 'Unknown', // Added mother name
            ]);

            // Create student address
            StudentAddress::create([
                'student_id' => $student->id,
                'address_type' => 'home',
                'address_line_1' => $studentData['address'],
                'city' => $studentData['city'],
                'state' => $studentData['state'],
                'pincode' => $studentData['pincode'],
                'country' => 'India',
                'is_primary' => true,
            ]);

            // Update class strength
            $class->increment('current_strength');

            $createdCount++;
            $this->command->info("✅ Created student: {$student->first_name} {$student->last_name} ({$student->admission_number}) in Class {$student->grade_level}{$student->section} (Roll: {$rollNumber})");
        }

        $this->command->newLine();
        $this->command->info("🎓 Student seeder completed successfully! Created {$createdCount} students.");

        if ($createdCount < count($students)) {
            $this->command->warn("Note: " . (count($students) - $createdCount) . " students were skipped (already exist or class not found).");
        }
    }

    /**
     * Helper methods
     */
    private function generateStudentId(): string
    {
        $lastStudent = Student::withTrashed()->orderBy('id', 'desc')->first();
        $number = $lastStudent ? (int) substr($lastStudent->student_id, 1) + 1 : 1;
        return 'S' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function generateAdmissionNumber(): string
    {
        $year = date('Y');
        $lastStudent = Student::withTrashed()
            ->where('admission_number', 'like', 'ADM' . $year . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastStudent) {
            $number = (int) substr($lastStudent->admission_number, -4) + 1;
        } else {
            $number = 1;
        }

        return 'ADM' . $year . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function getRandomReligion(): string
    {
        $religions = ['Hindu', 'Muslim', 'Christian', 'Sikh', 'Buddhist', 'Jain'];
        return $religions[array_rand($religions)];
    }

    private function getRandomCaste(): string
    {
        $castes = ['General', 'OBC', 'SC', 'ST'];
        return $castes[array_rand($castes)];
    }

    private function getMedicalInfo(): array
    {
        return [
            'has_allergies' => false,
            'has_chronic_illness' => false,
            'has_vision_problems' => false,
            'has_hearing_problems' => false,
            'emergency_medical_consent' => true,
            'height' => rand(140, 160) . ' cm',
            'weight' => rand(35, 50) . ' kg',
            'blood_pressure' => 'Normal',
            'last_checkup' => now()->subMonths(6)->format('Y-m-d'),
        ];
    }

    private function getRandomAllergies(): ?array
    {
        $allergies = [null, ['dust'], ['peanuts'], ['dairy']];
        return $allergies[array_rand($allergies)];
    }

    private function getRandomMedications(): ?array
    {
        $medications = [null, ['multivitamin'], ['calcium'], ['vitamin D']];
        return $medications[array_rand($medications)];
    }
}
