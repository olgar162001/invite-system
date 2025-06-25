<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsBalance extends Model
{
    protected $fillable = ['total_units', 'available_units'];
}
