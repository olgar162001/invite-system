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
        Schema::create('customer_sms_balances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('event_id')->nullable();
                $table->integer('units_assigned')->default(0);
                $table->integer('units_used')->default(0);
                $table->timestamps();
            
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
                       
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_sms_balances');
    }
};
