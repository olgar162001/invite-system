<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSmsUnit extends Model
{
    protected $fillable = ['event_id', 'user_id', 'units_assigned', 'units_used'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function remainingUnits() {
        return $this->units_assigned - $this->units_used;
    }
}

