<?php
// database/migrations/xxxx_xx_xx_create_sections_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('capacity')->default(30);
            $table->string('room_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            // Add indexes
            $table->index('class_id');
            $table->index('teacher_id');
            $table->index('is_active');
            $table->index(['class_id', 'is_active']);
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
