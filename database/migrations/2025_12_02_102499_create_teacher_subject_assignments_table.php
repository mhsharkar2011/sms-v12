<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_teacher_subject_assignments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_subject_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->integer('teaching_hours_per_week')->default(5);
            $table->json('schedule')->nullable();
            $table->date('start_date')->default(now());
            $table->date('end_date')->nullable();
            $table->boolean('is_primary_teacher')->default(false);
            $table->text('responsibilities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['teacher_id', 'subject_id']);
            $table->index(['class_id', 'subject_id']);
            $table->index('is_active');
            $table->unique(['teacher_id', 'subject_id', 'class_id'], 'idx_teacher_subject_class' );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_subject_assignments');
    }
};
