<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Guest;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->event_name,
                'start' => $event->date . 'T' . $event->time, // Ensure correct format
                'end' => $event->date . 'T' . $event->time,
                'description' => $event->event_host,
            ];
        });

        return response()->json(['success' => true, 'data' => $events]);
    }


}
