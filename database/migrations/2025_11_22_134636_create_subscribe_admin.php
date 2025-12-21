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
        Schema::create('subscribes', function (Blueprint $table) {
            $table->id('id_subscribe');
            $table->string('username');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['paid', 'pending', 'Failed', 'Cancelled'])->default('pending');
            $table->decimal('price', 10, 2)->default(59000);
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'e_wallet'])->default('credit_card');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribes');
    }
};
