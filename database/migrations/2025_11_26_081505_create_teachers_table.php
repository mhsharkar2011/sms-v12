<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->unique()->comment('Custom teacher ID like T001');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->enum('status', ['active', 'on_leave', 'inactive'])->default('active');
            $table->string('avatar')->nullable()->comment('Profile picture path');
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('qualification')->nullable();
            $table->text('bio')->nullable()->comment('Teacher biography');
            $table->json('subjects_taught')->nullable()->comment('Array of subjects teacher can teach');
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index('teacher_id');
            $table->index('email');
            $table->index('status');
            $table->index('subject');
            $table->index(['status', 'subject']);
        });

        // Pivot table for teacher-class relationships
        Schema::create('teacher_class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->string('subject')->nullable()->comment('Specific subject for this class');
            $table->enum('academic_year', ['2023-2024', '2024-2025', '2025-2026'])->default('2024-2025');
            $table->timestamps();

            // Unique constraint to prevent duplicate assignments
            $table->unique(['teacher_id', 'class_id', 'subject', 'academic_year']);
        });

        // Pivot table for teacher-subject relationships (if teachers can teach multiple subjects)
        Schema::create('teacher_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->string('subject_name');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('intermediate');
            $table->integer('years_of_experience')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->unique(['teacher_id', 'subject_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subject');
        Schema::dropIfExists('teacher_class');
        Schema::dropIfExists('teachers');
    }
};
