<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentAddress;
use Illuminate\Database\Seeder;

class StudentAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all students
        $students = Student::all();

        foreach ($students as $student) {
            // Create home address (primary)
            StudentAddress::create([
                'student_id' => $student->id,
                'address_type' => 'home',
                'address_line_1' => $student->address,
                'city' => $student->city,
                'state' => $student->state,
                'pincode' => $student->pincode,
                'country' => $student->country,
                'is_primary' => true,
                'notes' => 'Primary residence',
            ]);

            // For some students, create permanent address (different from home)
            if (rand(0, 1)) {
                StudentAddress::create([
                    'student_id' => $student->id,
                    'address_type' => 'permanent',
                    'address_line_1' => $this->generatePermanentAddress($student),
                    'city' => $this->getNativeCity($student->city),
                    'state' => $this->getNativeState($student->state),
                    'pincode' => rand(100000, 999999),
                    'country' => 'India',
                    'is_primary' => false,
                    'notes' => 'Native place / Permanent address',
                ]);
            }

            $this->command->info("Created addresses for student: {$student->first_name} {$student->last_name}");
        }

        $this->command->info('Student addresses seeded successfully!');
    }

    /**
     * Generate permanent address based on student's current address
     */
    private function generatePermanentAddress(Student $student): string
    {
        $villages = [
            'Gram', 'Gaon', 'Village', 'Kheda', 'Mauza', 'Khurd', 'Kalan'
        ];

        $village = $villages[array_rand($villages)];
        $number = rand(1, 99);

        return "{$number} {$village} " . $this->getNativeArea($student->city);
    }

    /**
     * Get native city based on current city
     */
    private function getNativeCity(string $currentCity): string
    {
        $nativeCities = [
            'Mumbai' => 'Ratnagiri',
            'Delhi' => 'Meerut',
            'Bangalore' => 'Mysore',
            'Chennai' => 'Madurai',
            'Kolkata' => 'Howrah',
            'Hyderabad' => 'Warangal',
            'Pune' => 'Satara',
            'Ahmedabad' => 'Vadodara',
            'Jaipur' => 'Ajmer',
            'Lucknow' => 'Kanpur',
        ];

        return $nativeCities[$currentCity] ?? $currentCity;
    }

    /**
     * Get native state based on current state
     */
    private function getNativeState(string $currentState): string
    {
        $nativeStates = [
            'Maharashtra' => 'Maharashtra',
            'Delhi' => 'Uttar Pradesh',
            'Karnataka' => 'Karnataka',
            'Tamil Nadu' => 'Tamil Nadu',
            'West Bengal' => 'West Bengal',
            'Telangana' => 'Telangana',
            'Gujarat' => 'Gujarat',
            'Rajasthan' => 'Rajasthan',
            'Uttar Pradesh' => 'Uttar Pradesh',
        ];

        return $nativeStates[$currentState] ?? $currentState;
    }

    /**
     * Get native area name
     */
    private function getNativeArea(string $city): string
    {
        $areas = [
            'Mumbai' => 'Konkan Region',
            'Delhi' => 'Western UP',
            'Bangalore' => 'Old Mysore Region',
            'Chennai' => 'Kongu Region',
            'Kolkata' => 'South Bengal',
            'Hyderabad' => 'Telangana Region',
            'Pune' => 'Western Maharashtra',
            'Ahmedabad' => 'Central Gujarat',
            'Jaipur' => 'Eastern Rajasthan',
            'Lucknow' => 'Central UP',
        ];

        return $areas[$city] ?? 'Rural Area';
    }
}
