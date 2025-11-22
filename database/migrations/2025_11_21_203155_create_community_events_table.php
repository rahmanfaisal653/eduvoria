<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_events', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('community_id'); // komunitas pemilik acara
            $table->unsignedBigInteger('user_id')->nullable(); // pembuat acara (opsional)
            $table->string('title');                   // judul acara
            $table->text('description')->nullable();   // deskripsi singkat
            $table->date('event_date');                // tanggal acara
            $table->time('start_time')->nullable();    // jam mulai
            $table->time('end_time')->nullable();      // jam selesai
            $table->string('location')->nullable();    // lokasi (online/offline)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_events');
    }
};
