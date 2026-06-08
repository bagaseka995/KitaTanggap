<?php

namespace App\Http\Controllers;

use App\Models\Bencana;
use App\Models\Donasi;
use App\Models\LaporanDistribusi;
use Illuminate\View\View;

class TransparencyController extends Controller
{
    /**
     * GET /transparansi
     * Halaman publik: laporan distribusi donasi per bencana.
     * Menampilkan semua bencana (aktif maupun selesai) beserta
     * total dana masuk, target, progress, dan rincian distribusi.
     *
     * Tidak memerlukan login (REQ-22).
     */
    public function index(): View
    {
        // Ambil semua bencana (aktif + nonaktif) dengan relasi laporan
        $bencanaList = Bencana::with(['laporanDistribusi' => function ($q) {
                $q->orderByDesc('tanggal_laporan');
            }])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($bencana) {
                // Hitung total donasi sukses
                $totalTerkumpul = Donasi::where('bencana_id', $bencana->id)
                    ->where('status_bayar', 'sukses')
                    ->sum('nominal');

                // Hitung total disalurkan dari laporan distribusi
                $totalDisalurkan = $bencana->laporanDistribusi->sum('jumlah_disalurkan');

                $targetDana = (float) $bencana->target_dana;
                $persentase = $targetDana > 0
                    ? min(100, round(($totalTerkumpul / $targetDana) * 100, 1))
                    : 0;

                // Hitung jumlah donatur unik (anonim — tanpa nama/email)
                $jumlahDonatur = Donasi::where('bencana_id', $bencana->id)
                    ->where('status_bayar', 'sukses')
                    ->distinct('email_donatur')
                    ->count('email_donatur');

                return (object) [
                    'id'                 => $bencana->id,
                    'nama_bencana'       => $bencana->nama_bencana,
                    'jenis_bencana'      => $bencana->jenis_bencana,
                    'lokasi'             => $bencana->lokasi,
                    'status_siaga'       => $bencana->status_siaga,
                    'label_siaga'        => $bencana->label_siaga,
                    'warna_siaga'        => $bencana->warna_siaga,
                    'status_aktif'       => $bencana->status_aktif,
                    'tanggal_kejadian'   => $bencana->tanggal_kejadian,
                    'target_dana'        => $targetDana,
                    'total_terkumpul'    => $totalTerkumpul,
                    'total_disalurkan'   => $totalDisalurkan,
                    'persentase'         => $persentase,
                    'jumlah_donatur'     => $jumlahDonatur,
                    'laporan'            => $bencana->laporanDistribusi,
                ];
            });

        // Statistik global
        $totalDanaGlobal     = Donasi::where('status_bayar', 'sukses')->sum('nominal');
        $totalBencana        = Bencana::count();
        $totalDonaturGlobal  = Donasi::where('status_bayar', 'sukses')
            ->distinct('email_donatur')->count('email_donatur');
        $totalLaporan        = LaporanDistribusi::count();

        return view('publik.transparansi', compact(
            'bencanaList',
            'totalDanaGlobal',
            'totalBencana',
            'totalDonaturGlobal',
            'totalLaporan'
        ));
    }
}
