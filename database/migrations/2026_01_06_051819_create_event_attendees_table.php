<?php
// database/migrations/xxxx_create_event_attendees_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();

            // Event relationship
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // User relationship (optional - for system users)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Attendee information
            $table->string('attendee_type'); // student, teacher, parent, staff, guest
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Student specific fields
            $table->string('roll_number')->nullable();
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->nullOnDelete();
            $table->string('section')->nullable();
            $table->string('grade_level')->nullable();

            // Teacher/Staff specific fields
            $table->string('designation')->nullable();
            $table->string('department')->nullable();

            // Parent specific fields
            $table->string('relationship')->nullable(); // mother, father, guardian
            $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();

            // Attendance tracking
            $table->string('status')->default('registered'); // registered, confirmed, attended, cancelled, no_show
            $table->timestamp('check_in_time')->nullable();
            $table->timestamp('check_out_time')->nullable();
            $table->text('attendance_notes')->nullable();

            // Registration details
            $table->timestamp('registration_date')->useCurrent();
            $table->json('additional_info')->nullable();
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();

            // Volunteer information
            $table->boolean('is_volunteer')->default(false);
            $table->string('volunteer_role')->nullable();

            // Special requirements
            $table->json('dietary_preferences')->nullable();
            $table->json('special_requirements')->nullable();

            // Emergency contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['event_id', 'status']);
            $table->index(['event_id', 'attendee_type']);
            $table->index(['event_id', 'class_id']);
            $table->index(['event_id', 'user_id']);
            $table->index(['registration_date']);
            $table->index(['check_in_time']);
            $table->index(['check_out_time']);

            // Unique constraint for user per event (if user is registered)
            $table->unique(['event_id', 'user_id'])->whereNotNull('user_id');

            // Unique constraint for email per event (to prevent duplicates)
            $table->unique(['event_id', 'email'])->whereNotNull('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
    }
};
