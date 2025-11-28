<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->string('subject_name');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('intermediate');
            $table->integer('years_of_experience')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->text('qualifications')->nullable();
            $table->text('specializations')->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->integer('max_classes_per_week')->default(20);
            $table->boolean('is_active')->default(true);
            $table->json('teaching_days')->nullable()->comment('Preferred teaching days');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint - a teacher can't have the same subject twice
            $table->unique(['teacher_id', 'subject_name']);

            // Indexes for better performance
            $table->index('teacher_id');
            $table->index('subject_name');
            $table->index('proficiency_level');
            $table->index('is_primary');
            $table->index('is_active');
            $table->index(['teacher_id', 'is_primary']);
            $table->index(['subject_name', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_subjects');
    }
};
