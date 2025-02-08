<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'invite_link' => 'required|string'
        ]);

        $phone = $request->phone;
        $inviteLink = $request->invite_link;

        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');

            $client = new \Twilio\Rest\Client($sid, $token);
            $message = $client->messages->create(
                "whatsapp:$phone",
                [
                    'from' => "whatsapp:$twilioWhatsAppNumber",
                    'body' => "You're invited! Click here to view your invitation: $inviteLink"
                ]
            );

            return response()->json(['success' => true, 'message' => 'WhatsApp message sent.']);
        } catch (\Exception $e) {
            \Log::error('Twilio Error: ' . $e->getMessage()); // Log error to storage/logs/laravel.log
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

}


