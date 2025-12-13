<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityEventUserTable extends Migration
{
    public function up()
    {
        Schema::create('community_event_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_event_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->unique(['community_event_id', 'user_id']);

            $table->foreign('community_event_id')
                  ->references('id')->on('community_events')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('community_event_user');
    }
}
