<?php
// database/seeders/EventSeeder.php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user to create events
        $admin = User::first();

        if (!$admin) {
            // Create admin user if doesn't exist
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@school.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        $events = [
            [
                'title' => 'Annual Sports Day 2024',
                'description' => 'Annual sports competition for all grades with various athletic events, races, and team games. All students, teachers, and parents are invited to participate and cheer.',
                'event_date' => now()->addDays(15)->setTime(9, 0),
                'end_date' => now()->addDays(15)->setTime(17, 0),
                'location' => 'School Ground',
                'address' => 'Main School Ground, Sports Complex',
                'event_type' => 'sports',
                'status' => 'published',
                'max_attendees' => 500,
                'requires_registration' => true,
                'registration_fee' => 0,
                'is_featured' => true,
                'contact_person' => 'Sports Teacher',
                'contact_email' => 'sports@school.com',
                'contact_phone' => '+91-9876543210',
                'organizer' => 'Sports Department',
                'target_audience' => 'Students, Teachers, Parents',
            ],
            [
                'title' => 'Science Exhibition',
                'description' => 'Annual science exhibition showcasing innovative projects by students from all grades. Categories include Physics, Chemistry, Biology, and Computer Science.',
                'event_date' => now()->addDays(10)->setTime(10, 0),
                'end_date' => now()->addDays(10)->setTime(16, 0),
                'location' => 'School Auditorium',
                'address' => 'Main School Building, Auditorium Hall',
                'event_type' => 'academic',
                'status' => 'published',
                'max_attendees' => 300,
                'requires_registration' => false,
                'is_featured' => true,
                'contact_person' => 'Science Department Head',
                'contact_email' => 'science@school.com',
                'organizer' => 'Science Department',
                'target_audience' => 'Students Grades 6-12, Parents',
            ],
            [
                'title' => 'Parent-Teacher Meeting',
                'description' => 'Quarterly parent-teacher meeting to discuss student progress, academic performance, and address any concerns. Individual appointments available.',
                'event_date' => now()->addDays(5)->setTime(14, 0),
                'end_date' => now()->addDays(5)->setTime(18, 0),
                'location' => 'Classrooms',
                'address' => 'Respective Classrooms as per schedule',
                'event_type' => 'meeting',
                'status' => 'published',
                'max_attendees' => 200,
                'requires_registration' => true,
                'registration_fee' => 0,
                'contact_person' => 'School Administrator',
                'contact_email' => 'admin@school.com',
                'contact_phone' => '+91-9876543211',
                'organizer' => 'School Administration',
                'target_audience' => 'Parents',
            ],
            [
                'title' => 'Cultural Fest - Rangmanch',
                'description' => 'Annual cultural festival featuring dance, music, drama, and art competitions. Students from all grades participate in various cultural activities.',
                'event_date' => now()->addDays(20)->setTime(16, 0),
                'end_date' => now()->addDays(20)->setTime(21, 0),
                'location' => 'School Auditorium',
                'address' => 'Main Auditorium, Cultural Wing',
                'event_type' => 'cultural',
                'status' => 'published',
                'max_attendees' => 400,
                'requires_registration' => true,
                'registration_fee' => 50,
                'contact_person' => 'Cultural Head',
                'contact_email' => 'cultural@school.com',
                'organizer' => 'Cultural Committee',
                'target_audience' => 'Students, Parents, Alumni',
            ],
            [
                'title' => 'Career Guidance Workshop',
                'description' => 'Interactive workshop for senior students to explore career options, higher education opportunities, and skill development. Industry experts invited.',
                'event_date' => now()->addDays(8)->setTime(11, 0),
                'end_date' => now()->addDays(8)->setTime(15, 0),
                'location' => 'Seminar Hall',
                'address' => 'Career Counseling Center, Block B',
                'event_type' => 'workshop',
                'status' => 'published',
                'max_attendees' => 100,
                'requires_registration' => true,
                'registration_deadline' => now()->addDays(6),
                'contact_person' => 'Career Counselor',
                'contact_email' => 'career@school.com',
                'organizer' => 'Career Guidance Cell',
                'target_audience' => 'Students Grades 9-12',
            ],
        ];

        $createdCount = 0;

        foreach ($events as $eventData) {
            // Generate slug from title
            $slug = Str::slug($eventData['title']);

            // Check if event with same slug exists
            $counter = 1;
            while (Event::where('slug', $slug)->exists()) {
                $slug = Str::slug($eventData['title']) . '-' . $counter;
                $counter++;
            }

            // Create excerpt from description
            $excerpt = Str::limit(strip_tags($eventData['description']), 150);

            Event::create([
                'title' => $eventData['title'],
                'slug' => $slug,
                'description' => $eventData['description'],
                'excerpt' => $excerpt,
                'featured_image' => $this->getEventImage($eventData['event_type']),
                'event_date' => $eventData['event_date'],
                'end_date' => $eventData['end_date'],
                'location' => $eventData['location'],
                'address' => $eventData['address'],
                'event_type' => $eventData['event_type'],
                'status' => $eventData['status'],
                'max_attendees' => $eventData['max_attendees'],
                'current_attendees' => 0,
                'registration_deadline' => $eventData['registration_deadline'] ?? null,
                'requires_registration' => $eventData['requires_registration'],
                'registration_fee' => $eventData['registration_fee'] ?? 0,
                'is_featured' => $eventData['is_featured'] ?? false,
                'is_public' => true,
                'meta_title' => $eventData['title'] . ' - School Event',
                'meta_description' => $excerpt,
                'user_id' => $admin->id,
                'contact_person' => $eventData['contact_person'],
                'contact_email' => $eventData['contact_email'],
                'contact_phone' => $eventData['contact_phone'] ?? null,
                'organizer' => $eventData['organizer'],
                'target_audience' => $eventData['target_audience'],
                'tags' => $this->getEventTags($eventData['event_type']),
            ]);

            $createdCount++;
            $this->command->info("Created event: {$eventData['title']}");
        }

        $this->command->info("✅ Event seeder completed successfully! Created {$createdCount} events.");
    }

    /**
     * Get appropriate image based on event type
     */
    private function getEventImage(string $eventType): string
    {
        return match($eventType) {
            'sports' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'academic' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'cultural' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'workshop' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'meeting' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            default => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        };
    }

    /**
     * Get tags based on event type
     */
    private function getEventTags(string $eventType): array
    {
        return match($eventType) {
            'sports' => ['sports', 'competition', 'athletics', 'games'],
            'academic' => ['science', 'education', 'exhibition', 'learning'],
            'cultural' => ['culture', 'art', 'music', 'dance', 'festival'],
            'workshop' => ['workshop', 'career', 'guidance', 'skills'],
            'meeting' => ['meeting', 'parents', 'discussion', 'progress'],
            default => ['event', 'school'],
        };
    }
}
