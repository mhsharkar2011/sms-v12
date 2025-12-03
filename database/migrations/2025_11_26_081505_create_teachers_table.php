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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique()->comment('Reference to users table');
            $table->string('teacher_id')->unique()->comment('Custom teacher ID like T001');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->enum('status', ['active', 'on_leave', 'inactive'])->default('active');
            $table->string('avatar')->nullable()->comment('Profile picture path');
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('qualification')->nullable();
            $table->text('bio')->nullable()->comment('Teacher biography');
            $table->json('subjects_taught')->nullable()->comment('Array of subjects teacher can teach');
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index('teacher_id');
            $table->index('email');
            $table->index('status');
            $table->index('subject');
            $table->index(['status', 'subject']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
