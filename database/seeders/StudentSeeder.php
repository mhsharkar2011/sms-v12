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
            $this->command->error('No active classes found for academic year: ' . $academicYear);
            return;
        }

        // Create only 3 students
        $students = [
            [
                'first_name' => 'Aarav',
                'last_name' => 'Sharma',
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
            ],
            [
                'first_name' => 'Ananya',
                'last_name' => 'Verma',
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
            ],
            [
                'first_name' => 'Vihaan',
                'last_name' => 'Gupta',
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
            ]
        ];

        $createdCount = 0;

        foreach ($students as $studentData) {
            // Find the class for this student
            $class = $classes->where('grade_level', $studentData['grade_level'])
                ->where('section', $studentData['section'])
                ->first();

            if (!$class) {
                $this->command->error("No class found for grade: {$studentData['grade_level']}, section: {$studentData['section']}");
                continue;
            }

            // Generate roll number based on current strength
            $rollNumber = $class->current_strength + 1;

            $student = Student::create([
                'student_id' => $this->generateStudentId(),
                'admission_number' => $this->generateAdmissionNumber(),
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'email' => $studentData['email'],
                'phone' => '+91-' . rand(70000, 99999) . rand(10000, 99999),
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
            $this->command->info("Created student: {$student->first_name} {$student->last_name} in {$class->name} (Roll: {$rollNumber})");
        }

        $this->command->info("Student seeder completed successfully! Created {$createdCount} students.");
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
        $lastStudent = Student::withTrashed()->where('admission_number', 'like', 'ADM' . $year . '%')->orderBy('id', 'desc')->first();

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
        ];
    }

    private function getRandomAllergies(): ?array
    {
        return null;
    }

    private function getRandomMedications(): ?array
    {
        return null;
    }
}
