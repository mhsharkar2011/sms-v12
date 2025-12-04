<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\GuardianAddress;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create guardian users with their children
        $guardians = [
            [
                'user' => [
                    'name' => 'John Wilson',
                    'email' => 'john.wilson@example.com',
                    'phone' => '+1-555-0101',
                    'password' => Hash::make('password'),
                ],
                'guardian' => [
                    'relationship' => 'Father',
                    'occupation' => 'Software Engineer',
                    'employer' => 'Tech Solutions Inc.',
                    'work_phone' => '+1-555-0102',
                    'work_email' => 'john.wilson@techsolutions.com',
                    'emergency_contact_name' => 'Sarah Wilson',
                    'emergency_contact_phone' => '+1-555-0103',
                    'emergency_contact_relationship' => 'Spouse',
                    'is_primary' => true,
                    'can_pickup' => true,
                    'receive_sms_alerts' => true,
                    'receive_email_alerts' => true,
                ],
                'address' => [
                    'address_type' => 'home',
                    'address_line_1' => '123 Main Street',
                    'city' => 'Springfield',
                    'state' => 'IL',
                    'postal_code' => '62701',
                    'country' => 'US',
                    'is_primary' => true,
                ],
                'students' => ['Aarav Sharma'.'Ananya Verma'] // Match the student names from StudentSeeder
            ],
            [
                'user' => [
                    'name' => 'Sarah Wilson',
                    'email' => 'sarah.wilson@example.com',
                    'phone' => '+1-555-0103',
                    'password' => Hash::make('password'),
                ],
                'guardian' => [
                    'relationship' => 'Mother',
                    'occupation' => 'Teacher',
                    'employer' => 'Springfield Elementary',
                    'work_phone' => '+1-555-0104',
                    'work_email' => 'sarah.wilson@springfield.edu',
                    'emergency_contact_name' => 'John Wilson',
                    'emergency_contact_phone' => '+1-555-0101',
                    'emergency_contact_relationship' => 'Spouse',
                    'is_primary' => true,
                    'can_pickup' => true,
                    'receive_sms_alerts' => true,
                    'receive_email_alerts' => true,
                ],
                'address' => [
                    'address_type' => 'home',
                    'address_line_1' => '123 Main Street',
                    'city' => 'Springfield',
                    'state' => 'IL',
                    'postal_code' => '62701',
                    'country' => 'US',
                    'is_primary' => true,
                ],
                'students' => ['Aarav Sharma'.'Ananya Verma']
            ],
            [
                'user' => [
                    'name' => 'Robert Johnson',
                    'email' => 'robert.johnson@example.com',
                    'phone' => '+1-555-0201',
                    'password' => Hash::make('password'),
                ],
                'guardian' => [
                    'relationship' => 'Father',
                    'occupation' => 'Doctor',
                    'employer' => 'City Hospital',
                    'work_phone' => '+1-555-0202',
                    'work_email' => 'r.johnson@cityhospital.org',
                    'emergency_contact_name' => 'Maria Johnson',
                    'emergency_contact_phone' => '+1-555-0203',
                    'emergency_contact_relationship' => 'Spouse',
                    'is_primary' => true,
                    'can_pickup' => true,
                    'receive_sms_alerts' => false,
                    'receive_email_alerts' => true,
                ],
                'address' => [
                    'address_type' => 'home',
                    'address_line_1' => '456 Oak Avenue',
                    'address_line_2' => 'Suite 101',
                    'city' => 'Springfield',
                    'state' => 'IL',
                    'postal_code' => '62702',
                    'country' => 'US',
                    'is_primary' => true,
                ],
                'students' => ['Vihaan Gupta']
            ]
        ];

        foreach ($guardians as $guardianData) {
            // Create user
            $user = User::create(array_merge($guardianData['user'], [
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]));

            // Create guardian profile
            $guardian = Guardian::create(array_merge($guardianData['guardian'], [
                'user_id' => $user->id,
                'guardian_id' => Guardian::generateGuardianId(),
                'is_active' => true,
            ]));

            // Create address
            GuardianAddress::create(array_merge($guardianData['address'], [
                'guardian_id' => $guardian->id,
            ]));

            // Attach students
            if (!empty($guardianData['students'])) {
                foreach ($guardianData['students'] as $studentName) {
                    // $nameParts = explode(' ', $studentName);
                    // $firstName = $nameParts[0];
                    // $lastName = $nameParts[1] ?? '';

                    $student = Student::first();

                    if ($student) {
                        $isPrimary = in_array($guardianData['guardian']['relationship'], ['Father', 'Mother']);

                        // Fix: Use proper JSON for emergency_contact_priority
                        $emergencyContactPriority = $isPrimary ? 1 : 2;

                        $guardian->students()->attach($student->id, [
                            'relationship_type' => strtolower($guardianData['guardian']['relationship']),
                            'is_primary_contact' => $isPrimary,
                            'can_pickup' => $guardianData['guardian']['can_pickup'],
                            'receive_reports' => true,
                            'receive_notifications' => true,
                            'emergency_contact_priority' => json_encode($emergencyContactPriority), // Fix: Convert to JSON
                            'special_instructions' => $this->getSpecialInstructions($guardianData['guardian']['relationship']),
                        ]);
                    } else {
                        $this->command->warn("Student not found: {$studentName}");
                    }
                }
            }

            $this->command->info("Created guardian: {$user->name} with ID: {$guardian->guardian_id}");
        }

        $this->command->info('Guardian seeder completed successfully!');
    }

    /**
     * Get special instructions based on relationship
     */
    private function getSpecialInstructions($relationship): ?string
    {
        $instructions = [
            'Father' => 'Please contact during business hours if urgent',
            'Mother' => 'Prefers email communication',
            'Guardian' => 'Contact only in emergencies',
            'Grandfather' => 'Limited phone access, prefer text messages',
            'Grandmother' => 'Available after 3 PM',
            'Aunt' => 'Secondary contact only',
            'Uncle' => 'Emergency contact only',
        ];

        return $instructions[$relationship] ?? null;
    }
}
