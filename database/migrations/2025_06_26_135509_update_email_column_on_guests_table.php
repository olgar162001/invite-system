<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailColumnOnGuestsTable extends Migration
{
    public function up()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropUnique(['email']); // Remove unique constraint
        });
    }

    public function down()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->unique('email'); // Restore if rolled back
        });
    }
}

