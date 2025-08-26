<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Event;
use App\Models\User;
use App\Models\Guest;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // return abort(500);

        $user = auth()->user();
        $events = $user->isAdmin() ? Event::all() : Event::where('user_id', $user->id)->get();

        // Log::info('Event Fetched successfully', [$events]);


        return view('event.index', compact('events'));
    }

    public function create()
    {
        $templates = Template::all();  // Pass templates to form
        return view('event.create', compact('templates'));
    }

    public function store(Request $request)
    {
        // Base validation (applies to all events)
        $rules = [
            'event_name'    => 'required|string|max:255',
            'event_type'    => 'required|string|max:100',
            'event_host'    => 'required|string|max:255',
            'date'          => 'required|date',
            'time'          => 'required',
            'venue'         => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'location_link' => 'nullable|string|max:500',
            'contacts'      => 'nullable|string|max:500',
            'customer_id'   => 'nullable|exists:users,id',
            'template_id'   => 'required|exists:templates,id',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video'         => 'nullable|mimes:mp4,mov,avi,wmv|max:10240',
            'audio'         => 'nullable|mimes:mp3,wav,ogg|max:5120',
        ];

        // Extra rules for wedding events
        if ($request->event_type === 'wedding') {
            $rules['groom'] = 'required|string|max:255';
            $rules['bride'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        // Create event
        $event = new Event($request->only([
            'event_name',
            'event_host',
            'event_type',
            'groom',
            'bride',
            'date',
            'time',
            'venue',
            'location_name',
            'location_link',
            'contacts',
            'template_id'
        ]));

        $event->user_id = auth()->id();

        // Handle media files (image, video, audio)
        foreach (['image', 'video', 'audio'] as $fileType) {
            if ($request->hasFile($fileType)) {
                $event->$fileType = $request->file($fileType)
                    ->store("events/{$fileType}s", 'public');
            }
        }

        $event->save();

        AuditHelper::log('Create Event', "Event '{$event->event_name}' created");

        return redirect('/event')->with('success', 'Event Created Successfully!');
    }


    public function show(string $id)
    {
        $event = Event::with('template')->findOrFail($id);
        $guests = Guest::where('event_id', $id)->get();

        return view('event.show', compact('event', 'guests'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $templates = Template::all();
        return view('event.edit', compact('event', 'templates'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required',
            'event_host' => 'required',
            'groom' => 'nullable',
            'bride' => 'nullable',
            'date' => 'required|date',
            'time' => 'required',
            'venue' => 'required',
            'location_name' => 'required',
            'customer_id' => 'nullable|exists:users,id',
            'template_id' => 'required|exists:templates,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
        ]);



        $event->fill($request->only([
            'event_name',
            'event_host',
            'event_type',
            'groom',
            'bride',
            'date',
            'time',
            'venue',
            'location_name',
            'location_link',
            'contacts',
            'template_id'
        ]));

        if (auth()->user()->isAdmin()) {
            $event->user_id = $request->input('customer_id');
        }

        // Handle media updates
        foreach (['image', 'video', 'audio'] as $fileType) {
            if ($request->hasFile($fileType)) {
                if ($event->$fileType)
                    Storage::disk('public')->delete($event->$fileType);
                $event->$fileType = $request->file($fileType)->store("events/{$fileType}s", 'public');
            }
        }

        $event->save();

        AuditHelper::log('Update Event', 'Event details were updated');
        return redirect('/event')->with('success', 'Event Updated');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        foreach (['image', 'video', 'audio'] as $fileType) {
            if ($event->$fileType)
                Storage::disk('public')->delete($event->$fileType);
        }

        $event->delete();

        AuditHelper::log('Delete Event', 'Event was deleted');

        return redirect('/event')->with('success', 'Event Deleted');
    }

    public function fetchEvents()
    {
        $events = Event::all();

        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'calendarId' => '1',
                'title' => $event->event_name ?? 'Unnamed Event',
                'category' => 'time',
                'dueDateClass' => '',
                'start' => $event->date ? $event->date . 'T' . ($event->time ?? '00:00:00') : null,
                'end' => $event->date ? $event->date . 'T' . ($event->time ?? '23:59:59') : null,
                'body' => $event->event_type ?? 'No description',
            ];
        });

        return response()->json($formattedEvents);
    }

    // JSON feed for FullCalendar
    public function feed()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->date . ' ' . $event->time, // adjust columns to your DB
                'description' => $event->description,
            ];
        });

        return response()->json($events);
    }
}
