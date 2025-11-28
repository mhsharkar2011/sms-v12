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
        Schema::create('guardian_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardian_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('relationship_type')->default('parent')->comment('parent, guardian, etc.');
            $table->boolean('is_primary_contact')->default(false);
            $table->boolean('can_pickup')->default(true);
            $table->boolean('receive_reports')->default(true);
            $table->boolean('receive_notifications')->default(true);
            $table->json('emergency_contact_priority')->nullable()->comment('Priority order for emergency contacts');
            $table->text('special_instructions')->nullable()->comment('Special instructions for this guardian-student relationship');
            $table->timestamps();

            // Unique constraint to prevent duplicate relationships
            $table->unique(['guardian_id', 'student_id']);

            // Indexes
            $table->index(['guardian_id', 'student_id']);
            $table->index(['relationship_type']);
            $table->index(['is_primary_contact']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardian_student');
    }
};
