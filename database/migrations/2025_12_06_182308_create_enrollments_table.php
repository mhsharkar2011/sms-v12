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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            // Student reference
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            // Class reference
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');

            // Enrollment details
            $table->string('enrollment_id')->unique()->nullable(); // Custom enrollment ID
            $table->date('enrollment_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Status: enrolled, pending, completed, withdrawn, transferred
            $table->enum('status', ['pending', 'enrolled', 'completed', 'withdrawn', 'transferred'])
                ->default('pending');

            // Academic performance
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->string('grade_letter', 2)->nullable(); // A, B, C, etc.
            $table->decimal('gpa', 3, 2)->nullable();

            // Attendance
            $table->integer('total_classes')->default(0);
            $table->integer('classes_attended')->default(0);
            $table->integer('classes_absent')->default(0);

            // Fees and payments
            $table->decimal('tuition_fee', 10, 2)->nullable();
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->nullable();

            // Withdrawal/Transfer details
            $table->date('withdrawal_date')->nullable();
            $table->text('withdrawal_reason')->nullable();
            $table->foreignId('transferred_to_class_id')->nullable()->constrained('school_classes');

            // Additional information
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable(); // For additional custom data

            // Audit fields
            $table->foreignId('enrolled_by')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();

            // Soft deletes
            $table->softDeletes();
            $table->timestamps();

            // Indexes for performance
            $table->index(['student_id', 'class_id']);
            $table->index(['class_id', 'status']);
            $table->index('enrollment_date');
            $table->index('status');
            $table->index('final_grade');

            // Unique constraint - student can't be enrolled in same class twice
            $table->unique(['student_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
