<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'preview_image',
        'template_file'
    ];

    /**
     * Get all events that use this template.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
