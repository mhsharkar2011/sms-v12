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
            $table->string('admission_number')->unique()->nullable()->comment('Custom admission number: ADM001, ADM002, etc.');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('blood_group')->nullable();
            $table->string('nationality')->default('Indian');
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('country')->default('India');

            // Emergency Contact Information (Separate from guardians)
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relation')->nullable();

            // Academic Information
            $table->date('admission_date')->nullable();
            $table->foreignId('class_id')->constrained('school_classes');
            $table->string('grade_level')->nullable();
            $table->string('roll_number')->nullable();
            $table->string('section')->nullable();
            $table->string('academic_year')->default('2024-2025');

            // Additional Information
            $table->string('avatar')->nullable();
            $table->json('medical_info')->nullable();
            $table->text('medical_notes')->nullable();
            $table->json('allergies')->nullable();
            $table->json('medications')->nullable();
            $table->string('transport_route')->nullable();
            $table->json('hostel_info')->nullable();
            $table->text('special_instructions')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'graduated', 'transferred', 'suspended'])->default('active');
            $table->date('last_attendance_date')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('is_boarder')->default(false);
            $table->boolean('uses_transport')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('student_id');
            $table->index('admission_number');
            $table->index('class_id');
            $table->index('roll_number');
            $table->index('status');
            $table->index(['class_id', 'roll_number']);
            $table->index(['class_id', 'section']);
            $table->index('created_at');
        });

        // Create student address table for multiple addresses
        Schema::create('student_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('address_type')->default('home')->comment('home, permanent, correspondence, etc.');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country')->default('India');
            $table->boolean('is_primary')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['student_id', 'address_type']);
            $table->index(['student_id', 'is_primary']);
        });

        // Create student documents table
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('document_type')->comment('birth_certificate, aadhaar, transfer_certificate, etc.');
            $table->string('document_number')->nullable();
            $table->string('file_path');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            // Indexes
            $table->index(['student_id', 'document_type']);
            $table->index('document_number');
            $table->index('is_verified');
        });

        // Create student academic history table
        Schema::create('student_academic_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('academic_year');
            $table->foreignId('class_id')->constrained('school_classes');
            $table->string('section')->nullable();
            $table->string('roll_number');
            $table->decimal('overall_percentage', 5, 2)->nullable();
            $table->string('final_grade')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_promoted')->default(false);
            $table->string('promoted_to_class')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['student_id', 'academic_year']);
            $table->index(['academic_year', 'class_id']);
            $table->index('is_promoted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_academic_histories');
        Schema::dropIfExists('student_documents');
        Schema::dropIfExists('student_addresses');
        Schema::dropIfExists('students');
    }
};
