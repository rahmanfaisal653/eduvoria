<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();

            // identitas komunitas
            $table->string('name');                     // nama komunitas
            $table->string('slug')->unique();          // untuk URL (misalnya: fotografer-alam)

            // deskripsi & kategori
            $table->text('description')->nullable();   // deskripsi komunitas
            $table->string('category')->nullable();    // misal: TechDesign, Hobi, dll

            // pemilik & anggota
            $table->unsignedBigInteger('owner_id');    // id user pembuat komunitas
            $table->unsignedInteger('members_count')
                  ->default(0);                       // jumlah anggota

            // foto (disimpan di tabel yang sama)
            $table->string('profile_image')->nullable();     // nama file foto profil
            $table->string('background_image')->nullable();  // nama file background

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
