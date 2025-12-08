<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'late', 'half_day', 'leave']);
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->decimal('working_hours', 4, 2)->nullable();
            $table->string('remark')->nullable();
            $table->foreignId('marked_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['staff_id', 'attendance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_attendances');
    }
};
