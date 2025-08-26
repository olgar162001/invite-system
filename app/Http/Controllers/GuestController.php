<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Event;
use App\Models\Guest;
use App\Models\SmsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuestsImport;
use App\Jobs\SendInvitationJob;
use App\Jobs\SendSmsInvitationJob;

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
        if ($request->hasFile('csv_file')) {
            return $this->importGuests($request, $id);
        }

        $guest = new Guest();
        $guest->name = $request->name;
        $guest->title = $request->title;
        $guest->email = $request->email;
        $guest->phone = $request->phone;
        $guest->type = $request->type;
        $guest->check_status = '0';
        $guest->status = '1';
        $guest->invite_link = $this->generateRandomString(10);
        $guest->checklist_token = $this->generateChecklistToken(6);
        $guest->user_id = auth()->id();
        $guest->event_id = $id;
        $guest->save();

        AuditHelper::log('Add Guest', 'Guests was added');
        return redirect('/event/' . $id)->with('success', 'Guest Added');
    }

    /**
     * Import guests from CSV or Excel.
     */
    public function importGuests(Request $request, $eventId)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,xlsx'
        ]);

        try {
            Excel::import(new GuestsImport($eventId), $request->file('csv_file'));
            AuditHelper::log('Import Guest', 'Guests were imported');
            return redirect('/event/' . $eventId)->with('success', 'Guests imported successfully.');
        } catch (\Exception $e) {
            return redirect('/event/' . $eventId)->with('error', 'Error importing guests: ' . $e->getMessage());
        }
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
            $guest = Guest::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'title' => 'nullable|string|max:100',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'type' => 'required|string',
                'event_id' => 'required|exists:events,id', // ensure the parent event exists
            ]);

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

            if (!$guest->checklist_token) {
                $guest->checklist_token = $this->generateChecklistToken(6);
            }

            $guest->user_id = auth()->id();

            // ✅ Set the correct event ID from the form
            $guest->event_id = $request->event_id;

            $guest->save();

            AuditHelper::log('Update Guest', 'Guest details were updated');

            return redirect()->back()->with('success', 'Guest Edited');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guest::find($id);
        $guest->delete();

        AuditHelper::log('Delete Guest', 'Guest was deleted');
        return redirect()->back()->with('success', 'Guest Deleted');
    }

    /**
     * Manually check-in a guest.
     */
    public function check($id)
    {
        $guest = Guest::find($id);
        $guest->check_status = '1';
        $guest->update();

        AuditHelper::log('Guest Checklist', 'Guest was checklisted');
        return redirect()->back()->with('success', 'Guest Checked Successfully');
    }

    /**
     * Search for a guest by token within an event.
     */
    public function search(Request $request, $eventId)
    {
        $token = $request->input('token');
        $event = Event::find($eventId);

        if (!$event) {
            return back()->with('error', 'Event not found.');
        }

        $guests = Guest::where('event_id', $eventId)
            ->where('checklist_token', $token)
            ->get();

        if ($guests->isEmpty()) {
            return redirect()->route('event.show', $eventId)->with('error', 'Guest not found.');
        }

        return view('event.show')->with([
            'event' => $event,
            'guests' => $guests
        ]);
    }



    public function sendInvitations(Request $request)
    {
        $guestIds = $request->input('guest_ids');
        $eventId = $request->input('event_id');

        if (!$guestIds || !$eventId) {
            return response()->json(['message' => 'Guests or Event not selected'], 400);
        }

        $event = Event::find($eventId);
        $setting = SmsSetting::first();

        if (!$event || !$setting) {
            return response()->json(['message' => 'Missing event or SMS settings'], 400);
        }

        $template = $setting->template_message ?? '';

        foreach ($guestIds as $guestId) {
            $guest = Guest::find($guestId);

            if ($guest) {
                // Send email
                dispatch(new SendInvitationJob($guest));

                if ($guest->phone) {

                    // Replace {{placeholders}} in the template
                    $message = str_replace(
                        ['{recipient_name}', '{couple_names}', '{event_date}', '{venue_name}', '{venue_area}', '{event_time}', '{code_number}', '{card_type}'],
                        [$guest->name, $event->groom, $event->date, $event->venue, $event->location_name, $event->time, $guest->checklist_token, $guest->type],
                        $template
                    );

                    // Send SMS job
                    dispatch(new SendSmsInvitationJob($guest->phone, $message));
                }
            }
        }

        // return response()->json(['message' => $count], 200);

        AuditHelper::log('Send SMS and Email Invitations', 'SMS and Email invitations were sent to event guests');
        
        return response()->json(['message' => 'Invitations sent successfully'], 200);
    }

    public function checkIn($qr_code)
    {
        $guest = Guest::where('qr_code', $qr_code)->first();

        if (!$guest) {
            return redirect()->back()->with('error', 'Invalid QR Code');
        }

        if ($guest->checked_in) {
            return redirect()->back()->with('info', 'Guest already checked in');
        }

        $guest->update(['checked_in' => true]);

        return redirect()->back()->with('success', $guest->name . ' checked in successfully');
    }

}
