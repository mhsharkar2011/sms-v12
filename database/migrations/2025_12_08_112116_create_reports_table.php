<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // academic, attendance, finance, exam, staff, inventory
            $table->string('format')->default('pdf'); // pdf, excel, csv
            $table->json('parameters')->nullable(); // Store filter parameters
            $table->string('file_path')->nullable(); // Path to generated report file
            $table->string('file_size')->nullable(); // File size in KB/MB
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('generated_at')->nullable();
            $table->dateTime('downloaded_at')->nullable();
            $table->integer('download_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index('type');
            $table->index('status');
            $table->index('generated_by');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
