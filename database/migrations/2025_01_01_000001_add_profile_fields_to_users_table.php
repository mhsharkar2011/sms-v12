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
        Schema::table('users', function (Blueprint $table) {
            // Add avatar field
            $table->string('avatar')->nullable()->after('email');

            // Add phone field
            $table->string('phone')->nullable()->after('avatar');

            // Add address field
            $table->text('address')->nullable()->after('phone');

            // Add status field with default value
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active')->after('address');

            // Add last login timestamp
            $table->timestamp('last_login_at')->nullable()->after('status');

            // Add soft deletes
            $table->softDeletes()->after('updated_at');

            // Add indexes for better performance
            $table->index('status');
            $table->index('last_login_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the columns in reverse order
            $table->dropIndex(['created_at']);
            $table->dropIndex(['last_login_at']);
            $table->dropIndex(['status']);

            $table->dropColumn([
                'avatar',
                'phone',
                'address',
                'status',
                'last_login_at',
                'deleted_at'
            ]);
        });
    }
};
