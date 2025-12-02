<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_class_subjects_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('student_classes')->onDelete('cascade');
            $table->string('subject_name');
            $table->string('subject_code')->unique();
            $table->text('description')->nullable();
            $table->integer('credit_hours')->default(1);
            $table->integer('weekly_classes')->default(5);
            $table->json('schedule')->nullable(); // {"day": "monday", "time": "09:00-10:00"}
            $table->string('textbook')->nullable();
            $table->string('syllabus_file')->nullable();
            $table->enum('type', ['compulsory', 'optional', 'elective'])->default('compulsory');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('class_id');
            $table->index('subject_code');
            $table->index(['class_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_subjects');
    }
};
