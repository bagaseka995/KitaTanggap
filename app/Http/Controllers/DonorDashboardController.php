<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Bencana;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonorDashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard donatur dengan ringkasan statistik.
     */
    public function index(): View
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email;

        $totalDonation = Donasi::where(function ($query) use ($userId, $userEmail) {
            $query->where('user_id', $userId)
                  ->orWhere('email_donatur', $userEmail);
        })->sukses()->sum('nominal');

        $totalTransactions = Donasi::where(function ($query) use ($userId, $userEmail) {
            $query->where('user_id', $userId)
                  ->orWhere('email_donatur', $userEmail);
        })->count();

        $activeDisasters = Bencana::where('status_aktif', true)->count();

        return view('dashboard.donatur', compact('totalDonation', 'totalTransactions', 'activeDisasters'));
    }

    /**
     * Tampilkan riwayat donasi untuk pengguna yang login sebagai donatur (REQ-23).
     */
    public function history(Request $request): View
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email;

        // Query donasi yang dimiliki oleh pengguna saat ini (berdasarkan user_id atau email)
        $query = Donasi::with('bencana')
            ->where(function ($q) use ($userId, $userEmail) {
                $q->where('user_id', $userId)
                  ->orWhere('email_donatur', $userEmail);
            })
            ->orderBy('created_at', 'desc');

        // Filter opsional: status_bayar (form GET parameter)
        if ($request->filled('status_bayar')) {
            $query->where('status_bayar', $request->status_bayar);
        }

        // Filter opsional: rentang tanggal (form GET parameter)
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // Pagination: 10 item per halaman
        $donations = $query->paginate(10);

        return view('dashboard.donatur_riwayat', compact('donations'));
    }
}
