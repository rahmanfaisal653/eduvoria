<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('community_id'); // id komunitas
            $table->string('author_name')->nullable();  // nama penulis (sederhana)
            $table->text('content');                    // isi postingan
            $table->string('image')->nullable();        // foto postingan (opsional)

            $table->timestamps();

            // kalau mau sangat dasar, foreign key boleh tidak dipakai.
            // Kalau mau pakai:
            // $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
};
