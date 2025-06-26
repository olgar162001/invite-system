<?php

namespace App\Helpers;

use App\Models\SmsSetting;

class SmsHelper
{
    public static function fetchSmsBalance()
    {
        $setting = SmsSetting::first();

        if (!$setting) {
            return [
                'success' => false,
                'message' => 'No SMS settings found',
            ];
        }

        $url = rtrim($setting->provider_url, '/') . '/api/sms/v1/balance';
        $authString = base64_encode($setting->username . ':' . $setting->password);

        $headers = [
            'Authorization: Basic ' . $authString,
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification in dev only

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch)) {
                $error = curl_error($ch);
                curl_close($ch);
                return [
                    'success' => false,
                    'message' => 'cURL error: ' . $error,
                ];
            }

            curl_close($ch);

            if ($httpCode >= 400 || !$response) {
                return [
                    'success' => false,
                    'message' => 'Failed to fetch balance from provider.',
                ];
            }

            $data = json_decode($response, true);

            return [
                'success' => true,
                'data' => $data,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }
}
