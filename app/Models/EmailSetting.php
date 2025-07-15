<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    // Table name (optional if it follows Laravel naming convention)
    protected $table = 'email_settings';

    // Fields that are mass assignable
    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
    ];

    // Optionally hide sensitive fields from being exposed
    protected $hidden = [
        'password',
    ];
}
