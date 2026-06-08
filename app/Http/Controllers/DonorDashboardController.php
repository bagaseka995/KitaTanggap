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

        $totalDonation = Donasi::where('user_id', $userId)->sukses()->sum('nominal');
        $totalTransactions = Donasi::where('user_id', $userId)->count();
        $activeDisasters = Bencana::where('status_aktif', true)->count();

        return view('dashboard.donatur', compact('totalDonation', 'totalTransactions', 'activeDisasters'));
    }

    /**
     * Tampilkan riwayat donasi untuk pengguna yang login sebagai donatur (REQ-23).
     */
    public function history(Request $request): View
    {
        $userId = auth()->id();

        // Query donasi yang hanya dimiliki oleh pengguna saat ini (user_id = auth()->id())
        // Jika donasi dilakukan saat belum login (user_id = null), donasi tidak muncul di riwayat ini.
        $query = Donasi::with('bencana')
            ->where('user_id', $userId)
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
