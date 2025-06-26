<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;

class SendSmsInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;
    public $message;

    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    public function handle()
    {
        $setting = \App\Models\SmsSetting::first();
        if (!$setting) return;

        $url = rtrim($setting->provider_url, '/') . '/api/sms/v1/text/single';
        $authString = base64_encode($setting->username . ':' . $setting->password);

        // Build correct payload format
        $payload = [
            'from' => 'NIAEVENTS',
            'to' => [$this->phone],
            'text' => $this->message,
            'reference' => Str::uuid()->toString(), // Unique ID for tracking
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $authString,
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Consider enabling in production

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code >= 400) {
            \Log::warning("❌ Failed to send SMS to {$this->phone}", [
                'code' => $code,
                'response' => $response,
                'payload' => $payload,
            ]);
        } else {
            \Log::info("✅ SMS sent to {$this->phone}", [
                'response' => $response,
            ]);
        }
    }
}
