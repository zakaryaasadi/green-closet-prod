<?php

namespace App\Traits;

trait FcmNotification
{
    public function sendNotification($userDeviceTokens, $title, $body)
    {
        try {
            $SERVER_API_KEY = config('fcm.server_api_key');
            // payload data, it will vary according to requirement
            $data = [
                'registration_ids' => $userDeviceTokens,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            curl_close($ch);

            return $response;

        } catch (\Throwable $exception) {
            //\Sentry\captureException($exception);
            return null;
        }
    }
}

