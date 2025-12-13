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

            $table->unsignedBigInteger('community_id'); 
            $table->string('author_name')->nullable();  
            $table->text('content');                    
            $table->string('image')->nullable();       

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
};
