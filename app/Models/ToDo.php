<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'due_date',
        'status',
        'assigned_to',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
