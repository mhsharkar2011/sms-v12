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
        Schema::table('sections', function (Blueprint $table) {
            $table->string('building', 10)->nullable()->after('room_number');
            $table->string('floor', 10)->nullable()->after('building');

            // Add index for faster queries
            $table->index(['building', 'floor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
             $table->dropColumn(['building', 'floor']);
        });
    }
};
