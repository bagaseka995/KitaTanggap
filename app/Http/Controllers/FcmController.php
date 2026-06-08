<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFcmToken;
use Illuminate\Http\JsonResponse;

class FcmController extends Controller
{
    /**
     * POST /api/fcm/register
     * Register FCM token for authenticated user.
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'fcm_token' => 'required|string|max:500',
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Upsert token
        $userFcmToken = UserFcmToken::updateOrCreate(
            ['fcm_token' => $request->fcm_token],
            ['user_id' => $user->id]
        );

        return response()->json([
            'message' => 'FCM token registered successfully',
            'data' => $userFcmToken,
        ]);
    }
}
