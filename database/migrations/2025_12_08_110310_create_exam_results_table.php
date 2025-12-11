<?php
// database/migrations/xxxx_create_exam_results_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();

            // Relationships - Using YOUR existing tables
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');

            // Use your existing class and section tables
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');

            // Marks and Grades
            $table->decimal('marks_obtained', 8, 2)->default(0);
            $table->decimal('total_marks', 8, 2);
            $table->decimal('percentage', 5, 2)->nullable()->virtualAs('(marks_obtained / total_marks) * 100');
            $table->string('grade', 2)->nullable();
            $table->decimal('grade_point', 3, 2)->nullable();

            // Status and Performance
            $table->string('status')->default('pending');
            $table->string('result_status')->default('pending');
            $table->integer('rank')->nullable();
            $table->text('remarks')->nullable();

            // Additional Info
            $table->boolean('is_absent')->default(false);
            $table->boolean('is_exempted')->default(false);
            $table->text('exemption_reason')->nullable();
            $table->decimal('grace_marks', 5, 2)->default(0);

            // Audit
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('graded_at')->nullable();
            $table->foreignId('published_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('published_at')->nullable();

            // Metadata
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['student_id', 'subject_id']);
            $table->index(['exam_id', 'subject_id']);
            $table->index(['class_id', 'section_id', 'exam_id']);
            $table->index('status');
            $table->index('result_status');
            $table->index('grade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
