<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateMessageToSmsSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('sms_settings', function (Blueprint $table) {
            $table->text('template_message')->nullable()->after('password');
        });
    }

    public function down()
    {
        Schema::table('sms_settings', function (Blueprint $table) {
            $table->dropColumn('template_message');
        });
    }
}
