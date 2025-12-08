<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'late', 'excused']);
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->string('remark')->nullable();
            $table->foreignId('marked_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['student_id', 'attendance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
