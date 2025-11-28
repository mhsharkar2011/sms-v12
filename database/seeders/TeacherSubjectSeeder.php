<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Database\Seeder;

class TeacherSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();
        $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science'];

        foreach ($teachers as $teacher) {
            $primarySet = false;

            foreach ($subjects as $subject) {
                if (rand(0, 1)) { // 50% chance to assign subject
                    TeacherSubject::create([
                        'teacher_id' => $teacher->id,
                        'subject_name' => $subject,
                        'proficiency_level' => $this->getRandomProficiency(),
                        'years_of_experience' => rand(1, 15),
                        'is_primary' => !$primarySet,
                        'qualifications' => $this->getRandomQualification($subject),
                        'is_active' => true
                    ]);

                    if (!$primarySet) {
                        $primarySet = true;
                    }
                }
            }
        }
    }

    private function getRandomProficiency(): string
    {
        $levels = ['beginner', 'intermediate', 'advanced', 'expert'];
        return $levels[array_rand($levels)];
    }

    private function getRandomQualification(string $subject): string
    {
        $qualifications = [
            "Bachelor's Degree in {$subject}",
            "Master's Degree in {$subject}",
            "PhD in {$subject}",
            "Professional Certification in {$subject}"
        ];

        return $qualifications[array_rand($qualifications)];
    }
}
