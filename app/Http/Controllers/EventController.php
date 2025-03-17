<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = auth()->id();
        $role = User::where('id',$id)->value('role');
        if($role==='admin'){
            $events = Event::all();
            
        }else{
            $events = Event::where('user_id', $id)->get();
        }

        return view('event.index')->with('events', $events);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required',
            'event_host' => 'required',
            'groom' => 'required',
            'bride' => 'required',
            'date' => 'required',
            'time' => 'required',
            'venue' => 'required',
            'location_name' => 'required',
            'customer_id' => 'nullable|exists:users,id', // Ensure customer exists
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
        ]);

        $event = new Event;
        $event->event_name = $request->input('event_name');
        $event->event_host = $request->input('event_host');
        $event->event_type = $request->input('event_type');
        $event->groom = $request->input('groom');
        $event->bride = $request->input('bride');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->venue = $request->input('venue');
        $event->location_name = $request->input('location_name');
        $event->location_link = $request->input('location_link');
        $event->contacts = $request->input('contacts');

        // Determine the customer ID
       /* if (auth()->user()->isAdmin()) { // Assuming an isAdmin() method in User model
            $event->user_id = $request->input('user_id'); // Admin assigns a customer
        } else {
            $event->user_id = auth()->id(); // Customers create their own events
        }*/

        $event->user_id = auth()->id(); // Logged-in user creating the event

        // Handle media uploads
        if ($request->hasFile('image')) {
            $event->image = $request->file('image')->store('events/images', 'public');
        }
        if ($request->hasFile('video')) {
            $event->video = $request->file('video')->store('events/videos', 'public');
        }
        if ($request->hasFile('audio')) {
            $event->audio = $request->file('audio')->store('events/audio', 'public');
        }

        $event->save();

        return redirect('/event')->with('success', 'Event Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        $guests = Guest::where('event_id', $id)->get();

        return view('event.show', compact('event', 'guests'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required',
            'event_host' => 'required',
            'groom' => 'required',
            'bride' => 'required',
            'date' => 'required',
            'time' => 'required',
            'venue' => 'required',
            'location_name' => 'required',
            'customer_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
        ]);

        $event->event_name = $request->input('event_name');
        $event->event_host = $request->input('event_host');
        $event->event_type = $request->input('event_type');
        $event->groom = $request->input('groom');
        $event->bride = $request->input('bride');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->venue = $request->input('venue');
        $event->location_name = $request->input('location_name');
        $event->location_link = $request->input('location_link');
        $event->contacts = $request->input('contacts');

        if (auth()->user()->isAdmin()) {
            $event->customer_id = $request->input('customer_id'); // Admin can update customer_id
        }

        // Handle media updates
        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $event->image = $request->file('image')->store('events/images', 'public');
        }

        if ($request->hasFile('video')) {
            if ($event->video) {
                Storage::disk('public')->delete($event->video);
            }
            $event->video = $request->file('video')->store('events/videos', 'public');
        }

        if ($request->hasFile('audio')) {
            if ($event->audio) {
                Storage::disk('public')->delete($event->audio);
            }
            $event->audio = $request->file('audio')->store('events/audio', 'public');
        }

        $event->save();

        return redirect('/event')->with('success', 'Event Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        // Delete associated files if they exist
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        if ($event->video) {
            Storage::disk('public')->delete($event->video);
        }
        if ($event->audio) {
            Storage::disk('public')->delete($event->audio);
        }

        $event->delete();

        return redirect('/event')->with('success', 'Event Deleted');
    }


    public function fetchEvents()
    {
        $events = Event::all();

        // Convert events into JSON format required by Toast UI Calendar
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
    

}
