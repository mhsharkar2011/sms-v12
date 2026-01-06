<?php
// database/seeders/EventAttendeeSeeder.php (Fully Fixed)

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventAttendeeSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::take(3)->get();

        if ($events->isEmpty()) {
            $this->command->info('No events found. Please run EventSeeder first.');
            return;
        }

        // Get admin user for registered_by
        $admin = User::first();
        if (!$admin) {
            $admin = User::first();
        }
        if (!$admin) {
            $this->command->error('No users found. Please create users first.');
            return;
        }

        // Get students with proper handling
        $students = Student::with('user')->take(5)->get();
        if ($students->isEmpty()) {
            $this->command->info('No students found. Creating sample students...');
            $students = $this->createSampleStudents($admin->id);
        }

        // Get teachers with proper handling
        $teachers = Teacher::all();
        if ($teachers->isEmpty()) {
            $this->command->info('No teachers found. Creating sample teachers...');
            $teachers = $this->createSampleTeachers($admin->id);
        }

        // Get guardians/parents with proper handling
        $parents = Guardian::all();
        if ($parents->isEmpty()) {
            $this->command->info('No parents found. Creating sample parents...');
            $parents = $this->createSampleParents($admin->id);
        }

        $attendeeCount = 0;

        foreach ($events as $event) {
            $this->command->info("Adding attendees for event: {$event->title}");

            // Add students as attendees
            foreach ($students as $student) {
                try {
                    // Extract section safely
                    $section = $this->extractSection($student->section);

                    // Get student name safely
                    $studentName = trim($student->first_name . ' ' . ($student->last_name ?? ''));
                    if (empty($studentName)) {
                        $studentName = "Student " . $student->id;
                    }

                    // Get email safely
                    $email = $student->email;
                    if (empty($email)) {
                        $email = 'student' . $student->id . '@school.com';
                    }

                    // Get roll number safely
                    $rollNumber = $student->roll_number;
                    if (empty($rollNumber)) {
                        $rollNumber = $student->id;
                    }

                    EventAttendee::create([
                        'event_id' => $event->id,
                        'user_id' => $student->user_id ?? null,
                        'attendee_type' => 'student',
                        'name' => $studentName,
                        'email' => $email,
                        'roll_number' => $rollNumber,
                        'class_id' => $student->class_id ?? 1,
                        'section' => $section,
                        'grade_level' => $student->grade_level ?? '1',
                        'status' => 'confirmed',
                        'registered_by' => $admin->id,
                    ]);
                    $attendeeCount++;
                    $this->command->info("  ✓ Added student: {$studentName}");
                } catch (\Exception $e) {
                    $this->command->warn("  ✗ Failed to add student {$student->first_name}: " . $e->getMessage());
                }
            }

            // Add teachers as attendees
            foreach ($teachers as $teacher) {
                try {
                    // Get teacher name safely
                    $teacherName = $teacher->name;
                    if (empty($teacherName)) {
                        $teacherName = "Teacher " . $teacher->id;
                    }

                    // Get email safely
                    $email = $teacher->email;
                    if (empty($email)) {
                        $email = 'teacher' . $teacher->id . '@school.com';
                    }

                    EventAttendee::create([
                        'event_id' => $event->id,
                        'user_id' => $teacher->user_id ?? null,
                        'attendee_type' => 'teacher',
                        'name' => $teacherName,
                        'email' => $email,
                        'designation' => $teacher->designation ?? 'Teacher',
                        'department' => $teacher->department ?? 'Academic',
                        'status' => 'confirmed',
                        'registered_by' => $admin->id,
                    ]);
                    $attendeeCount++;
                    $this->command->info("  ✓ Added teacher: {$teacherName}");
                } catch (\Exception $e) {
                    $this->command->warn("  ✗ Failed to add teacher: " . $e->getMessage());
                }
            }

            // Add parents as attendees
            foreach ($parents as $parent) {
                try {
                    // Get parent name safely
                    $parentName = $parent->name;
                    if (empty($parentName)) {
                        $parentName = "Parent " . $parent->id;
                    }

                    // Get email safely
                    $email = $parent->email;
                    if (empty($email)) {
                        $email = 'parent' . $parent->id . '@school.com';
                    }

                    // Get relationship safely
                    $relationship = $parent->relationship ?? 'Parent';

                    EventAttendee::create([
                        'event_id' => $event->id,
                        'user_id' => $parent->user_id ?? null,
                        'attendee_type' => 'parent',
                        'name' => $parentName,
                        'email' => $email,
                        'relationship' => $relationship,
                        'status' => 'confirmed',
                        'registered_by' => $admin->id,
                    ]);
                    $attendeeCount++;
                    $this->command->info("  ✓ Added parent: {$parentName}");
                } catch (\Exception $e) {
                    $this->command->warn("  ✗ Failed to add parent: " . $e->getMessage());
                }
            }
        }

        $this->command->info("✅ EventAttendeeSeeder completed successfully! Created {$attendeeCount} attendees.");
    }

    /**
     * Extract section from JSON or return default
     */
    private function extractSection($section): string
    {
        if (empty($section)) {
            return 'A'; // Default section
        }

        // If section is already a simple string
        if (is_string($section) && !Str::startsWith($section, '{')) {
            return substr($section, 0, 10); // Limit to 10 characters
        }

        // If section is a JSON string
        if (is_string($section) && Str::startsWith($section, '{')) {
            try {
                $data = json_decode($section, true);
                if (is_array($data)) {
                    if (isset($data['name'])) {
                        return substr($data['name'], 0, 10);
                    }
                    if (isset($data['code'])) {
                        return substr($data['code'], 0, 10);
                    }
                    if (isset($data['section'])) {
                        return substr($data['section'], 0, 10);
                    }
                }
            } catch (\Exception $e) {
                // If JSON decode fails, return default
            }
        }

        // If section is an object
        if (is_object($section)) {
            if (isset($section->name)) {
                return substr($section->name, 0, 10);
            }
            if (isset($section->code)) {
                return substr($section->code, 0, 10);
            }
            if (isset($section->section)) {
                return substr($section->section, 0, 10);
            }
        }

        // Default fallback
        return 'A';
    }

    /**
     * Create sample students if none exist
     */
    private function createSampleStudents($adminId)
    {
        $students = [];
        $studentNames = [
            ['first' => 'John', 'last' => 'Doe'],
            ['first' => 'Jane', 'last' => 'Smith'],
            ['first' => 'Bob', 'last' => 'Johnson'],
            ['first' => 'Alice', 'last' => 'Williams'],
            ['first' => 'Charlie', 'last' => 'Brown'],
        ];

        foreach ($studentNames as $index => $name) {
            $student = Student::create([
                'first_name' => $name['first'],
                'last_name' => $name['last'],
                'email' => strtolower($name['first']) . '.' . strtolower($name['last']) . '@school.com',
                'roll_number' => $index + 1,
                'class_id' => 1,
                'section' => 'A',
                'grade_level' => '10',
                'status' => 'active',
            ]);
            $students[] = $student;
        }

        return collect($students);
    }

    /**
     * Create sample teachers if none exist
     */
    private function createSampleTeachers($adminId)
    {
        $teachers = [];
        $teacherNames = ['Dr. Sarah Johnson', 'Mr. Michael Brown', 'Ms. Emily Davis'];

        foreach ($teacherNames as $index => $name) {
            $teacher = Teacher::create([
                'name' => $name,
                'email' => 'teacher' . ($index + 1) . '@school.com',
                'phone' => '+1234567890',
                'subject' => ['Math', 'Science', 'English'][$index],
                'qualification' => 'M.Ed.',
                'experience' => '5+ years',
                'status' => 'active',
            ]);
            $teachers[] = $teacher;
        }

        return collect($teachers);
    }

    /**
     * Create sample parents if none exist
     */
    private function createSampleParents($adminId)
    {
        $parents = [];
        $parentNames = ['David Wilson', 'Lisa Thompson'];

        foreach ($parentNames as $index => $name) {
            $parent = Guardian::create([
                'name' => $name,
                'email' => 'parent' . ($index + 1) . '@school.com',
                'phone' => '+123456789' . ($index + 1),
                'occupation' => 'Business',
                'address' => '123 Main St, City',
                'relationship' => 'Father',
            ]);
            $parents[] = $parent;
        }

        return collect($parents);
    }
}
