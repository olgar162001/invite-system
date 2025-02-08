<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Generate a random alphanumeric string.
     */
    public function generateRandomString($length = 10)
    {
        return strtoupper(Str::random($length));
    }

    /**
     * Generate a unique 6-character token for checklist.
     */
    public function generateChecklistToken($length = 6)
    {
        return strtoupper(Str::random($length));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $guest = new Guest();
        $guest->name = $request->name;
        $guest->title = $request->title;
        $guest->email = $request->email;
        $guest->phone = $request->phone;
        $guest->type = $request->type;
        $guest->check_status = '0';
        $guest->status = '1';
        $guest->invite_link = $this->generateRandomString(10); // Generate invite link
        $guest->checklist_token = $this->generateChecklistToken(6); // Generate checklist token
        $guest->user_id = auth()->id();
        $guest->event_id = $id;
        $guest->save();

        return redirect('/event/' . $id)->with('success', 'Guest Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guest = Guest::find($id);
        return view('card')->with('guest', $guest);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guest = Guest::find($id);
        return view('edit_guest')->with('guest', $guest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guest = Guest::find($id);
        $guest->name = $request->name;
        $guest->title = $request->title;
        $guest->email = $request->email;
        $guest->phone = $request->phone;
        $guest->type = $request->type;
        $guest->check_status = '0';

        if ($request->status == 'Attending') {
            $guest->status = '2';
        } elseif ($request->status == 'Not Attending') {
            $guest->status = '0';
        } else {
            $guest->status = '1';
        }

        // Ensure token remains unchanged unless manually updated
        if (!$guest->checklist_token) {
            $guest->checklist_token = $this->generateChecklistToken(6);
        }

        $guest->user_id = auth()->id();
        $guest->event_id = $id;
        $guest->update();

        return redirect('/event/' . $id)->with('success', 'Guest Edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guest::find($id);
        $guest->delete();

        return redirect('/event')->with('success', 'Guest Deleted');
    }

    /**
     * Manually check-in a guest.
     */
    public function check($id)
    {
        $guest = Guest::find($id);
        $guest->check_status = '1';
        $guest->update();

        return redirect()->back()->with('success', 'Guest Checked Successfully');
    }

    
    public function search(Request $request, $eventId)
    {
        $token = $request->input('token');
    
        // Get the event
        $event = Event::where('id', $eventId)->first();
    
        if (!$event) {
            return back()->with('error', 'Event not found.');
        }
    
        // Search for a guest using the token within the event
        $guests = Guest::where('event_id', $eventId)
                    ->where('checklist_token', $token)
                    ->get();
    
        if ($guests->isEmpty()) {
            return redirect()->route('events.show', $eventId)->with('error', 'Guest not found.');
        }
    
        return view('event.show')->with([
            'event' => $event,
            'guests' => $guests
        ]);
    }
    

}
