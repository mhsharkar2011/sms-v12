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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('guardian_id')->unique()->comment('Custom guardian identifier: G001, G002, etc.');
            $table->string('relationship')->nullable()->comment('Father, Mother, Guardian, etc.');
            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('work_email')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->text('medical_notes')->nullable()->comment('Any medical information about children');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->boolean('is_primary')->default(false)->comment('Primary guardian');
            $table->boolean('can_pickup')->default(true)->comment('Authorized for student pickup');
            $table->boolean('receive_sms_alerts')->default(true);
            $table->boolean('receive_email_alerts')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['guardian_id']);
            $table->index(['relationship']);
            $table->index(['is_active']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
