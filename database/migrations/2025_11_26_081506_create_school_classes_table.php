<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('grade_level');
            $table->string('section');
            $table->foreignId('class_teacher_id')->nullable()->constrained('teachers');
            $table->integer('capacity')->default(40);
            $table->integer('current_strength')->default(0);
            $table->string('room_number')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('academic_year')->default('2024-2025');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['grade_level', 'section', 'academic_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
