<?php

namespace App\Services;

use App\Mail\SertifikatRelawanMail;
use App\Models\Penugasan;
use App\Models\Sertifikat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikatService
{
    /**
     * Generate sertifikat PDF untuk penugasan tertentu, simpan ke storage,
     * catat di database, lalu kirim email notifikasi ke relawan.
     *
     * @param int $penugasanId
     * @return Sertifikat
     * @throws \Exception
     */
    public function generate(int $penugasanId): Sertifikat
    {
        // 1. Ambil data penugasan lengkap
        $penugasan = Penugasan::with(['relawan.user', 'bencana'])
            ->findOrFail($penugasanId);

        // 2. Generate kode unik (Format: SERT-TAHUN-RANDOM6)
        $kode = $this->generateUniqueCode();

        // 3. Render template PDF dari Blade view dengan layout landscape A4
        $pdf = Pdf::loadView('sertifikat.template', compact('penugasan', 'kode'))
            ->setPaper('a4', 'landscape');

        // 4. Simpan file ke public disk
        $fileName = "sertifikat/{$kode}.pdf";
        Storage::disk('public')->put($fileName, $pdf->output());

        // 5. Simpan ke database
        $sertifikat = Sertifikat::create([
            'penugasan_id'    => $penugasanId,
            'kode_sertifikat' => $kode,
            'tanggal_terbit'  => now()->toDateString(),
            'file_path'       => "storage/{$fileName}", // path relatif untuk public URL
        ]);

        // 6. Kirim email ke relawan dengan attachment PDF
        try {
            Mail::to($penugasan->relawan->user->email)->send(new SertifikatRelawanMail($sertifikat));
        } catch (\Exception $e) {
            \Log::warning("Gagal mengirim email sertifikat untuk penugasan #{$penugasanId}: " . $e->getMessage());
        }

        return $sertifikat;
    }

    /**
     * Generate kode sertifikat unik SERT-{TAHUN}-{RANDOM_6}
     */
    private function generateUniqueCode(): string
    {
        $tahun = date('Y');
        
        do {
            $random = strtoupper(Str::random(6));
            // Hindari karakter membingungkan (opsional, tapi bagus untuk UX)
            $random = strtr($random, ['0' => 'A', 'O' => 'B', 'I' => 'C', '1' => 'D']);
            $kode = "SERT-{$tahun}-{$random}";
        } while (Sertifikat::where('kode_sertifikat', $kode)->exists());

        return $kode;
    }
}
