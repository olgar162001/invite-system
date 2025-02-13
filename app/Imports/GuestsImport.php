<?php

namespace App\Imports;

use App\Models\Guest;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class GuestsImport implements ToModel
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * Generate a random alphanumeric string.
     */
    private function generateRandomString($length = 10)
    {
        return strtoupper(Str::random($length));
    }

    /**
     * Generate a unique 6-character token for checklist.
     */
    private function generateChecklistToken($length = 6)
    {
        return strtoupper(Str::random($length));
    }

    public function model(array $row)
    {
        return new Guest([
            'name' => $row[0],
            'title' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'type' => $row[4],
            'check_status' => '0',
            'status' => '1',
            'invite_link' => $this->generateRandomString(10),
            'checklist_token' => $this->generateChecklistToken(6),
            'user_id' => auth()->id(),
            'event_id' => $this->eventId,
        ]);
    }
}
