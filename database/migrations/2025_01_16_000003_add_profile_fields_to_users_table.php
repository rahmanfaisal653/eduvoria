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
            $table->string('profile_picture')->nullable();
            $table->text('bio')->nullable();
            $table->string('hobi')->nullable();
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->integer('followers_count')->default(0);
            $table->integer('following_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_picture', 'bio', 'hobi', 'role', 'followers_count', 'following_count']);
        });
    }
};
