<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationPreferenceController extends Controller
{
    /**
     * Tampilkan halaman pengaturan notifikasi
     */
    public function show(): View
    {
        return view('pengaturan.notifikasi', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Update preferensi notifikasi via AJAX
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'notif_aktif'     => 'required|boolean',
            'lokasi_domisili' => 'nullable|string|max:100',
            'fcm_aktif'       => 'required|boolean',
        ]);

        $user = auth()->user();

        // Update preferensi email dan lokasi
        $user->update([
            'notif_aktif'     => $validated['notif_aktif'],
            'lokasi_domisili' => $validated['lokasi_domisili'],
        ]);

        // Jika push notification dimatikan, hapus semua token FCM user ini
        if (!$validated['fcm_aktif']) {
            $user->fcmTokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Preferensi notifikasi berhasil diperbarui'
        ]);
    }
}
