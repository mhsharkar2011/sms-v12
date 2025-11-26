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
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "10-A", "11-B"
            $table->string('grade_level'); // e.g., "10", "11"
            $table->string('section'); // e.g., "A", "B"
            $table->foreignId('class_teacher_id')->nullable()->constrained('teachers');
            $table->integer('capacity')->default(40);
            $table->integer('current_strength')->default(0);
            $table->string('room_number')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['grade_level', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
