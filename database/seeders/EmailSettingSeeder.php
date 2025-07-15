<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailSetting;


class EmailSettingSeeder extends Seeder
{
    public function run()
    {
        EmailSetting::create([
            'mailer' => 'smtp',
            'host' => 'smtp.mailtrap.io',
            'port' => '587',
            'username' => 'your_username',
            'password' => 'your_password',
            'encryption' => 'tls',
            'from_address' => 'noreply@example.com',
            'from_name' => 'My App'
        ]);
    }
}

