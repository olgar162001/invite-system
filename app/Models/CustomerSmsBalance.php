<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSmsBalance extends Model
{
    protected $fillable = ['user_id', 'event_id', 'units_assigned', 'units_used'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function remainingUnits() {
        return $this->units_assigned - $this->units_used;
    }

    public function scopeForEvent($query, $eventId) {
        return $query->where('event_id', $eventId);
    }

    public function scopeGeneral($query) {
        return $query->whereNull('event_id');
    }
}
