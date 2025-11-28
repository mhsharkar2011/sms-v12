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
        Schema::create('guardian_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardian_id')->constrained()->onDelete('cascade');
            $table->string('address_type')->default('home')->comment('home, work, mailing, etc.');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country')->default('US');
            $table->boolean('is_primary')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['guardian_id', 'address_type']);
            $table->index(['is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardian_addresses');
    }
};
