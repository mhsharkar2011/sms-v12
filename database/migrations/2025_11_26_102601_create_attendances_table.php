<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('attendance_date');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->enum('status', ['present', 'absent', 'late', 'half_day', 'holiday'])->default('present');
            $table->string('remark')->nullable();
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->decimal('working_hours', 4, 2)->nullable();
            $table->foreignId('recorded_by')->constrained('teachers')->onDelete('cascade');
            $table->string('academic_year')->default('2024-2025');
            $table->timestamps();

            // Shorter unique constraint name
            $table->unique(['student_id', 'attendance_date', 'subject_id'], 'attendance_student_date_subject_unique');

            // Shorter index names
            $table->index('attendance_date', 'attendance_date_idx');
            $table->index('student_id', 'attendance_student_idx');
            $table->index('class_id', 'attendance_class_idx');
            $table->index('status', 'attendance_status_idx');
            $table->index(['attendance_date', 'class_id'], 'attendance_date_class_idx');
            $table->index(['attendance_date', 'student_id'], 'attendance_date_student_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
