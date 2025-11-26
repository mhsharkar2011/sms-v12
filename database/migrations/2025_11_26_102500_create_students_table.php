<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('admission_number')->unique();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('blood_group')->nullable();
            $table->string('nationality')->default('Indian');
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->text('address');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('country')->default('India');

            // Parent/Guardian Information
            $table->string('father_name');
            $table->string('father_phone')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_email')->nullable();
            $table->string('mother_name');
            $table->string('mother_phone')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->text('guardian_address')->nullable();

            // Academic Information
            $table->date('admission_date');
            $table->foreignId('class_id')->constrained('school_classes');
            $table->string('roll_number');
            $table->string('section')->nullable();
            $table->string('academic_year')->default('2024-2025');

            // Additional Information
            $table->string('avatar')->nullable();
            $table->json('medical_info')->nullable();
            $table->string('transport_route')->nullable();
            $table->json('hostel_info')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'graduated', 'transferred'])->default('active');
            $table->date('last_attendance_date')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('student_id');
            $table->index('admission_number');
            $table->index('class_id');
            $table->index('roll_number');
            $table->index('status');
            $table->index(['class_id', 'roll_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
