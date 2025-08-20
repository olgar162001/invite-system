<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'checklist_token',
        'title',
        'invite_link',
        'type',
        'event_id',
        'qr_code', 
    ];

    /**
     * Booted method to auto-generate QR code when creating a guest.
     */
    protected static function booted()
    {
        static::creating(function ($guest) {
            if (empty($guest->qr_code)) {
                // Use UUID to make it unique
                $guest->qr_code = Str::uuid()->toString();
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
