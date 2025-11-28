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
                'students' => ['Emma Wilson', 'Noah Wilson'] // These should exist in students table
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
                'students' => ['Emma Wilson', 'Noah Wilson']
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
                'students' => ['Sophia Johnson']
            ],
            [
                'user' => [
                    'name' => 'Maria Johnson',
                    'email' => 'maria.johnson@example.com',
                    'phone' => '+1-555-0203',
                    'password' => Hash::make('password'),
                ],
                'guardian' => [
                    'relationship' => 'Mother',
                    'occupation' => 'Nurse',
                    'employer' => 'City Hospital',
                    'work_phone' => '+1-555-0204',
                    'work_email' => 'm.johnson@cityhospital.org',
                    'emergency_contact_name' => 'Robert Johnson',
                    'emergency_contact_phone' => '+1-555-0201',
                    'emergency_contact_relationship' => 'Spouse',
                    'is_primary' => false,
                    'can_pickup' => true,
                    'receive_sms_alerts' => true,
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
                'students' => ['Sophia Johnson']
            ],
            [
                'user' => [
                    'name' => 'David Chen',
                    'email' => 'david.chen@example.com',
                    'phone' => '+1-555-0301',
                    'password' => Hash::make('password'),
                ],
                'guardian' => [
                    'relationship' => 'Guardian',
                    'occupation' => 'Business Owner',
                    'employer' => 'Chen Enterprises',
                    'work_phone' => '+1-555-0302',
                    'work_email' => 'david@chenenterprises.com',
                    'emergency_contact_name' => 'Lisa Chen',
                    'emergency_contact_phone' => '+1-555-0303',
                    'emergency_contact_relationship' => 'Sister',
                    'is_primary' => true,
                    'can_pickup' => true,
                    'receive_sms_alerts' => true,
                    'receive_email_alerts' => true,
                ],
                'address' => [
                    'address_type' => 'home',
                    'address_line_1' => '789 Pine Street',
                    'city' => 'Springfield',
                    'state' => 'IL',
                    'postal_code' => '62703',
                    'country' => 'US',
                    'is_primary' => true,
                ],
                'students' => ['Michael Chen', 'Olivia Chen']
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
                    $student = Student::where('first_name', explode(' ', $studentName)[0])
                        ->where('last_name', explode(' ', $studentName)[1])
                        ->first();

                    if ($student) {
                        $isPrimary = in_array($guardianData['guardian']['relationship'], ['Father', 'Mother']);

                        $guardian->students()->attach($student->id, [
                            'relationship_type' => strtolower($guardianData['guardian']['relationship']),
                            'is_primary_contact' => $isPrimary,
                            'can_pickup' => $guardianData['guardian']['can_pickup'],
                            'receive_reports' => true,
                            'receive_notifications' => true,
                            'emergency_contact_priority' => $isPrimary ? 1 : 2,
                            'special_instructions' => $this->getSpecialInstructions($guardianData['guardian']['relationship']),
                        ]);
                    }
                }
            }

            $this->command->info("Created guardian: {$user->name} with ID: {$guardian->guardian_id}");
        }

        // Create additional random guardians
        $this->createRandomGuardians(10);

        $this->command->info('Guardian seeder completed successfully!');
    }

    /**
     * Create random guardians for testing
     */
    private function createRandomGuardians($count = 10): void
    {
        $relationships = ['Father', 'Mother', 'Guardian', 'Grandfather', 'Grandmother', 'Aunt', 'Uncle'];
        $occupations = [
            'Software Engineer',
            'Teacher',
            'Doctor',
            'Nurse',
            'Accountant',
            'Manager',
            'Sales Representative',
            'Engineer',
            'Consultant',
            'Designer',
            'Analyst'
        ];
        $cities = ['Springfield', 'Shelbyville', 'Ogdenville', 'North Haverbrook', 'Capital City'];
        $states = ['IL', 'NY', 'CA', 'TX', 'FL', 'WA'];

        for ($i = 0; $i < $count; $i++) {
            $firstName = $this->randomFirstName();
            $lastName = $this->randomLastName();
            $relationship = $relationships[array_rand($relationships)];

            $user = User::create([
                'name' => "{$firstName} {$lastName}",
                'email' => strtolower("{$firstName}.{$lastName}@example.com"),
                'phone' => '+1-555-' . sprintf('%04d', rand(1000, 9999)),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            $guardian = Guardian::create([
                'user_id' => $user->id,
                'guardian_id' => Guardian::generateGuardianId(),
                'relationship' => $relationship,
                'occupation' => $occupations[array_rand($occupations)],
                'employer' => $this->randomCompany(),
                'work_phone' => '+1-555-' . sprintf('%04d', rand(1000, 9999)),
                'work_email' => strtolower("{$firstName}@{$this->randomDomain()}"),
                'emergency_contact_name' => $this->randomFirstName() . ' ' . $this->randomLastName(),
                'emergency_contact_phone' => '+1-555-' . sprintf('%04d', rand(1000, 9999)),
                'emergency_contact_relationship' => $relationships[array_rand($relationships)],
                'is_primary' => in_array($relationship, ['Father', 'Mother']),
                'can_pickup' => rand(0, 1),
                'receive_sms_alerts' => rand(0, 1),
                'receive_email_alerts' => rand(0, 1),
                'is_active' => true,
            ]);

            // Create address
            GuardianAddress::create([
                'guardian_id' => $guardian->id,
                'address_type' => 'home',
                'address_line_1' => rand(100, 9999) . ' ' . $this->randomStreet(),
                'city' => $cities[array_rand($cities)],
                'state' => $states[array_rand($states)],
                'postal_code' => sprintf('%05d', rand(10000, 99999)),
                'country' => 'US',
                'is_primary' => true,
            ]);

            // Attach to random students (1-3 students per guardian)
            $randomStudents = Student::inRandomOrder()->take(rand(1, 3))->get();
            foreach ($randomStudents as $student) {
                $guardian->students()->attach($student->id, [
                    'relationship_type' => strtolower($relationship),
                    'is_primary_contact' => rand(0, 1),
                    'can_pickup' => rand(0, 1),
                    'receive_reports' => rand(0, 1),
                    'receive_notifications' => rand(0, 1),
                    'emergency_contact_priority' => rand(1, 3),
                    'special_instructions' => rand(0, 1) ? $this->randomSpecialInstruction() : null,
                ]);
            }
        }

        $this->command->info("Created {$count} random guardians");
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

    /**
     * Helper methods for random data generation
     */
    private function randomFirstName(): string
    {
        $firstNames = ['James', 'Mary', 'John', 'Patricia', 'Robert', 'Jennifer', 'Michael', 'Linda', 'William', 'Elizabeth', 'David', 'Susan', 'Richard', 'Jessica', 'Joseph', 'Sarah', 'Thomas', 'Karen', 'Charles', 'Nancy'];
        return $firstNames[array_rand($firstNames)];
    }

    private function randomLastName(): string
    {
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'];
        return $lastNames[array_rand($lastNames)];
    }

    private function randomCompany(): string
    {
        $companies = ['Tech Corp', 'Global Solutions', 'Innovate Inc', 'Future Systems', 'Digital Works', 'Creative Labs', 'Enterprise Solutions', 'NextGen Tech', 'Visionary Systems', 'Progress Inc'];
        return $companies[array_rand($companies)];
    }

    private function randomDomain(): string
    {
        $domains = ['company.com', 'business.org', 'enterprise.net', 'corp.io', 'group.com', 'holdings.org'];
        return $domains[array_rand($domains)];
    }

    private function randomStreet(): string
    {
        $streets = ['Main St', 'Oak Ave', 'Maple Dr', 'Cedar Ln', 'Pine St', 'Elm St', 'Washington Ave', 'Park Rd', 'Lake St', 'Hill St'];
        return $streets[array_rand($streets)];
    }

    private function randomSpecialInstruction(): string
    {
        $instructions = [
            'Please call before visiting',
            'Prefers text messages over calls',
            'Available only after 5 PM',
            'No contact on weekends',
            'Emergency contact only',
            'Can pick up after 3:30 PM',
            'Allergic to peanuts',
            'Special dietary requirements',
            'Medical condition: asthma',
            'Requires wheelchair access',
        ];
        return $instructions[array_rand($instructions)];
    }
}
