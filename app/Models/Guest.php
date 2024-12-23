<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'title', 'invite_link', 'type', 'event_id'];
    use HasFactory;

    public function Event():BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
