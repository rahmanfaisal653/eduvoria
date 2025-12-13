<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->change();
            $table->foreign('owner_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('community_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('community_id')->change();
            $table->foreign('community_id')
                ->references('id')->on('communities')
                ->onDelete('cascade');
        });

        Schema::table('community_events', function (Blueprint $table) {
            $table->unsignedBigInteger('community_id')->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();

            $table->foreign('community_id')
                ->references('id')->on('communities')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->nullOnDelete(); // atau cascadeOnDelete kalau mau
        });
    }

    public function down(): void
    {
        Schema::table('community_events', function (Blueprint $table) {
            $table->dropForeign(['community_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('community_posts', function (Blueprint $table) {
            $table->dropForeign(['community_id']);
        });

        Schema::table('communities', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
        });
    }
};
