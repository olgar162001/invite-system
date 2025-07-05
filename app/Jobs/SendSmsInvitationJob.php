<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;
use Log;

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
        try {
            $setting = \App\Models\SmsSetting::first();
            if (!$setting) {
                \Log::warning("SMS Setting not found.");
                return;
            }

            $url = rtrim($setting->provider_url, '/') . '/api/sms/v1/text/single';
            $authString = base64_encode($setting->username . ':' . $setting->password);

            $payload = [
                'from' => 'NIAEVENTS',
                'to' => $this->phone,
                'text' => $this->message,
                'reference' => \Str::uuid()->toString(),
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
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($response === false) {
                throw new \Exception('Curl error: ' . curl_error($ch));
            }

            curl_close($ch);

            if ($code >= 400) {
                Log::warning("Failed to send SMS to {$this->phone}", [
                    'code' => $code,
                    'response' => $response,
                    'payload' => $payload,
                ]);
            } else {
                Log::info("SMS sent to {$this->phone}", [
                    'response' => $response,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error("SMS job failed", [
                'error' => $e->getMessage(),
            ]);

            // You can rethrow or just exit
            Log::error("Error Thrown: " . $e);
            throw $e; // If you rethrow, Laravel will retry depending on your config
        }
    }

}
