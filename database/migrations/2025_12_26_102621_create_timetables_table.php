<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room_number')->nullable();
            $table->string('period_number');
            $table->string('academic_year')->default('2024-2025');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            // // Unique constraint to prevent overlapping schedules
            // $table->unique(['class_id', 'day_of_week', 'period_number', 'academic_year']);
            // $table->unique(['teacher_id', 'day_of_week', 'period_number', 'academic_year']);
            // $table->unique(['room_number', 'day_of_week', 'period_number', 'academic_year']);

            // Use shorter unique constraint names
            $table->unique(['class_id', 'day_of_week', 'period_number', 'academic_year'], 'timetable_class_day_period_unique');
            $table->unique(['teacher_id', 'day_of_week', 'period_number', 'academic_year'], 'timetable_teacher_day_period_unique');
            $table->unique(['room_number', 'day_of_week', 'period_number', 'academic_year'], 'timetable_room_day_period_unique');


            // Indexes with shorter names
            $table->index('class_id', 'timetable_class_idx');
            $table->index('teacher_id', 'timetable_teacher_idx');
            $table->index('subject_id', 'timetable_subject_idx');
            $table->index('day_of_week', 'timetable_day_idx');
            $table->index('is_active', 'timetable_active_idx');
            $table->index(['class_id', 'day_of_week'], 'timetable_class_day_idx');
            $table->index(['teacher_id', 'day_of_week'], 'timetable_teacher_day_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
