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
        Schema::table('to_dos', function (Blueprint $table) {
            $table->date('due_date')->nullable();
            $table->string('status')->default('Pending');
            $table->string('assigned_to')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('do', function (Blueprint $table) {
            //
        });
    }
};
