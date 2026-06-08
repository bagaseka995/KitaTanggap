<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\View\View;

class SertifikatController extends Controller
{
    /**
     * GET /verifikasi/{kode}
     * Halaman publik untuk memverifikasi keaslian sertifikat relawan.
     * Tidak membutuhkan login.
     *
     * @param string $kode
     * @return View
     */
    public function verifikasi(string $kode): View
    {
        $sertifikat = Sertifikat::where('kode_sertifikat', $kode)
            ->with(['penugasan.relawan.user', 'penugasan.bencana'])
            ->first();

        return view('publik.verifikasi', compact('sertifikat', 'kode'));
    }
}
