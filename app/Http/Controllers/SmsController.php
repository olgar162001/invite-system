<?php

namespace App\Http\Controllers;

use App\Models\SmsSetting;
use App\Models\CustomerSmsBalance;
use App\Models\SmsBalance;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function settings()
    {
        $setting = SmsSetting::first();
        return view('sms.setting', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'provider_url' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        SmsSetting::updateOrCreate(['id' => 1], $request->only('provider_url', 'username', 'password'));

        return redirect()->back()->with('success', 'SMS settings updated successfully!');
    }

    public function balance()
{
    $setting = SmsSetting::first();
    if (!$setting) {
        return redirect()->back()->withErrors(['msg' => 'No SMS settings found']);
    }

    // Build full URL from DB + balance endpoint
    $url = rtrim($setting->provider_url, '/') . '/api/sms/v1/balance';

    // Encode username and password as Base64 (username:password)
    $authString = base64_encode($setting->username . ':' . $setting->password);

    try {
        $ch = curl_init();

        $headers = [
            'Authorization: Basic ' . $authString,
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Only in dev/testing

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return back()->withErrors(['msg' => 'cURL error: ' . $error]);
        }

        curl_close($ch);

        if ($httpCode >= 400 || !$response) {
            return back()->withErrors(['msg' => 'Failed to fetch balance from provider.']);
        }

        $data = json_decode($response, true);

        if (!isset($data['sms_balance'])) {
            return back()->withErrors(['msg' => 'Balance not found in provider response.']);
        }

        $providerBalance = (int) $data['sms_balance'];

        $balance = \App\Models\SmsBalance::firstOrCreate(['id' => 1]);
        $balance->total_units = $providerBalance;
        $balance->available_units = $providerBalance - \App\Models\CustomerSmsBalance::sum('units_assigned');
        $balance->save();

        return view('sms.balance', ['balance' => $balance]);

    } catch (\Exception $e) {
        return back()->withErrors(['msg' => 'Exception: ' . $e->getMessage()]);
    }
}

    


    public function assign()
    {
        $customers = User::where('role', 'customer')->get();
        $allocations = CustomerSmsBalance::with(['user', 'event'])->latest()->get();
    
        return view('sms.assign', compact('customers', 'allocations'));
    }
    

    public function assignToCustomer(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'units' => 'required|integer|min:1',
            'event_id' => 'nullable|exists:events,id',
        ]);
    
        // Check provider balance
        $balance = SmsBalance::first(); // or your preferred source
        if ($balance->available_units < $request->units) {
            return back()->withErrors(['msg' => 'Not enough SMS units available']);
        }
    
        // Update or create
        $allocation = SmsAllocation::firstOrNew([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
        ]);
        $allocation->units_assigned += $request->units;
        $allocation->save();
    
        // Decrease from provider
        $balance->available_units -= $request->units;
        $balance->save();
    
        return back()->with('success', 'Units assigned successfully!');
    }

    public function sendInvitation(Request $request)
    {
        $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'recipients' => 'required|array|min:1',
            'message' => 'required|string',
        ]);
    
        $unitsNeeded = count($request->recipients);
        $allocation = CustomerSmsBalance::where('user_id', auth()->id())
            ->where('event_id', $request->event_id)
            ->first();
    
        if (!$allocation || $allocation->remainingUnits() < $unitsNeeded) {
            return back()->withErrors(['msg' => 'Not enough SMS units available for this event.']);
        }
    
        // Proceed to send SMS
        foreach ($request->recipients as $recipient) {
            // callSmsApi($recipient, $request->message);
        }
    
        $allocation->increment('units_used', $unitsNeeded);
    
        return back()->with('success', 'SMS sent successfully!');
    }
}
