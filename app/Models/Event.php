<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_host', 
        'event_type', 
        'groom', 
        'bride', 
        'location',
        'venue',
        'date',
        'time',
        'contacts',
        'user_id',
        'image',
        'video',
        'audio',
        'template_id'
    ];

    // Relationship: Event belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Event has many Guests
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    // Relationship: Event belongs to a customer (if used separately from user_id)
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relationship: Event uses a Template
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}
