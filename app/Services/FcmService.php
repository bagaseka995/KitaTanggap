<?php

namespace App\Services;

use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\UserFcmToken;

class FcmService
{
    /**
     * Get OAuth2 access token for FCM.
     *
     * @return string|null
     */
    protected function getAccessToken(): ?string
    {
        try {
            $keyFilePath = storage_path('app/firebase-service-account.json');
            if (!file_exists($keyFilePath)) {
                Log::warning('Firebase service account JSON not found.');
                return null;
            }

            $client = new Client();
            $client->setAuthConfig($keyFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            
            // Get token and return it
            $token = $client->fetchAccessTokenWithAssertion();
            return $token['access_token'] ?? null;
        } catch (\Exception $e) {
            Log::error('FCM getAccessToken error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send Push Notification via FCM HTTP v1 API.
     *
     * @param string $token FCM Device Token
     * @param string $title Notification Title
     * @param string $body Notification Body
     * @param array $data Additional Data Payload
     * @return bool True if successful, false otherwise.
     */
    public function sendPushNotification(string $token, string $title, string $body, array $data = []): bool
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        $keyFilePath = storage_path('app/firebase-service-account.json');
        if (!file_exists($keyFilePath)) {
            return false;
        }

        $serviceAccount = json_decode(file_get_contents($keyFilePath), true);
        $projectId = $serviceAccount['project_id'] ?? null;

        if (!$projectId) {
            Log::error('FCM project_id not found in service account json.');
            return false;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ]
        ];

        try {
            $response = Http::withToken($accessToken)
                ->post($url, $payload);

            if ($response->successful()) {
                return true;
            }

            $error = $response->json();
            Log::error("FCM Send Error: ", $error);

            // Handle invalid or unregistered tokens (e.g., UNREGISTERED)
            $errorCode = $error['error']['details'][0]['errorCode'] ?? null;
            if ($errorCode === 'UNREGISTERED' || $errorCode === 'INVALID_ARGUMENT') {
                UserFcmToken::where('fcm_token', $token)->delete();
                Log::info("FCM token deleted: {$token}");
            }

            return false;
        } catch (\Exception $e) {
            Log::error('FCM Request Error: ' . $e->getMessage());
            return false;
        }
    }
}
