<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['event_name',
    'event_host', 
    'event_type', 
    'groom', 
    'bride', 
    'location',
    'venue',
    'date',
    'time',
    'contacts',
    'user_id'
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Guest(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}
