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
        Schema::create('report_admin', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('reported_by');
            $table->text('description');
            $table->string('priority')->default('low');
            $table->text('content_summary');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_admin');
    }
};
