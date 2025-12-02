<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_teacher_class_assignments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_class_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('student_classes')->onDelete('cascade');
            $table->enum('role', ['class_teacher', 'subject_teacher', 'assistant'])->default('subject_teacher');
            $table->json('subjects')->nullable(); // Subjects taught by this teacher in this class
            $table->date('start_date')->default(now());
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('responsibilities')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['teacher_id', 'class_id']);
            $table->index('role');
            $table->index('is_active');
            $table->unique(['teacher_id', 'class_id', 'role', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_class_assignments');
    }
};
