<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_student_class_assignments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_class_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->string('roll_number')->nullable();
            $table->enum('status', ['active', 'inactive', 'transferred', 'graduated'])->default('active');
            $table->date('enrollment_date')->default(now());
            $table->date('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Unique constraint to prevent duplicate assignments
            $table->unique(['student_id', 'class_id']);

            // Indexes for performance
            $table->index('student_id');
            $table->index('class_id');
            $table->index('status');
            $table->index(['student_id', 'status'], 'idx_student_status' );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_class_assignments');
    }
};
