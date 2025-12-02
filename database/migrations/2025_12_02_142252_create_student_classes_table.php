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
        Schema::create('student_classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name'); // e.g., "Class 1", "Grade 10", "Year 12"
            $table->string('class_code')->unique(); // e.g., "CLS-001", "G10", "12A"
            $table->text('description')->nullable();

            // Academic year information
            $table->string('academic_year'); // e.g., "2024-2025"
            $table->enum('semester', ['first', 'second', 'third', 'annual'])->nullable();

            // Class details
            $table->integer('max_students')->default(30);
            $table->integer('current_students_count')->default(0);
            $table->decimal('monthly_fee', 10, 2)->nullable();
            $table->decimal('annual_fee', 10, 2)->nullable();

            // Class timing
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->json('class_days')->nullable(); // e.g., ["monday", "wednesday", "friday"]

            // Teacher/Class teacher assignment
            $table->foreignId('class_teacher_id')->nullable()->constrained('users')->onDelete('set null');

            // Room information
            $table->string('room_number')->nullable();
            $table->string('building')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'completed', 'cancelled'])->default('active');

            // Additional metadata
            $table->json('subjects')->nullable(); // Array of subjects taught in this class
            $table->json('requirements')->nullable(); // e.g., ["textbook", "calculator", "uniform"]

            // Soft deletes
            $table->softDeletes();
            $table->timestamps();

            // Indexes for performance
            $table->index('class_code');
            $table->index('academic_year');
            $table->index('status');
            $table->index('class_teacher_id');
            $table->index(['academic_year', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_classes');
    }
};
