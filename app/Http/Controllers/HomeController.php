<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Helpers\SmsHelper;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */


    public function index()
    {
        $id = auth()->id();
        $role = User::where('id', $id)->value('role');
        $today = Carbon::today();

        if ($role === 'admin') {
            // Admin sees all upcoming events
            $events = Event::where('date', '>=', $today)->get();
        } else {
            // Customers see only their upcoming events
            $events = Event::where('user_id', $id)
                ->where('date', '>=', $today)
                ->get();
        }

        // Get guests attending these events
        $guests = Guest::whereIn('event_id', $events->pluck('id'))->get();

        // Count guests by status
        $attending_guest = $guests->where('status', '2')->count();
        $pending_guest = $guests->where('status', '1')->count();
        $not_guest = $guests->where('status', '0')->count();

        $response = SmsHelper::fetchSmsBalance();

        $balance = $response['data']['sms_balance'] ?? 'N/L';

        if (!$response['success']) {
            return view('home')->with([
                'events' => $events,
                'guest' => $guests,
                'attending' => $attending_guest,
                'pending' => $pending_guest,
                'not' => $not_guest,
                'balance' => $balance,
                'error' => 'Failed to fetch SMS Balance! Check your internet connection.'
            ]);
        } else {
            return view('home')->with([
                'events' => $events,
                'guest' => $guests,
                'attending' => $attending_guest,
                'pending' => $pending_guest,
                'not' => $not_guest,
                'balance' => $balance
            ]);
        }
    }



    public function profile()
    {
        return view('profile');
    }

    public function template()
    {
        return view('card-template');
    }

    /**
     * Confirm guest attendance and send .ics event invite.
     */
    public function confirm($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->status = '2';
        $guest->save();

        // Fetch event details
        $event = Event::findOrFail($guest->event_id);

        // Generate .ics file content dynamically
        $icsContent = "BEGIN:VCALENDAR\r\n";
        $icsContent .= "VERSION:2.0\r\n";
        $icsContent .= "BEGIN:VEVENT\r\n";
        $icsContent .= "UID:" . uniqid() . "\r\n";
        $icsContent .= "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n";
        $icsContent .= "DTSTART:" . date('Ymd\THis\Z', strtotime($event->date . ' ' . $event->time)) . "\r\n";
        $icsContent .= "DTEND:" . date('Ymd\THis\Z', strtotime($event->date . ' ' . $event->time . ' +2 hours')) . "\r\n";
        $icsContent .= "SUMMARY:" . $event->event_name . "\r\n";
        $icsContent .= "DESCRIPTION:" . ($event->event_type ?: 'No description available') . "\r\n";
        $icsContent .= "LOCATION:" . ($event->venue ?: 'No location specified') . "\r\n";
        $icsContent .= "END:VEVENT\r\n";
        $icsContent .= "END:VCALENDAR\r\n";

        // Save the .ics file in storage
        $fileName = "event_" . $guest->id . ".ics";
        Storage::disk('local')->put("public/ics/$fileName", $icsContent);
        $filePath = storage_path("app/public/ics/$fileName");

        // Send email with .ics file
        Mail::to($guest->email)->send(new EventConfirmationMail($guest, $event, $filePath));

        return view('response')->with('guest', $guest);
    }

    /**
     * Deny guest attendance.
     */
    public function deny($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->status = '0';
        $guest->save();
        return view('response')->with('guest', $guest);
    }
}
