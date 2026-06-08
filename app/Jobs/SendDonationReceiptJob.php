<?php

namespace App\Jobs;

use App\Mail\DonationReceipt;
use App\Models\Donasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDonationReceiptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Jumlah percobaan ulang jika gagal kirim.
     */
    public int $tries = 3;

    /**
     * Waktu tunggu antar percobaan (detik).
     */
    public array $backoff = [10, 30, 60];

    public function __construct(public readonly Donasi $donasi) {}

    /**
     * Kirim email bukti donasi ke email donatur.
     * Prioritas: email_donatur (dari form) → user.email (jika login).
     */
    public function handle(): void
    {
        // Eager load relasi yang dibutuhkan oleh Mailable
        $this->donasi->load('bencana', 'user');

        // Tentukan alamat email tujuan
        $email = $this->donasi->email_donatur
            ?? $this->donasi->user?->email;

        if (!$email) {
            Log::warning("SendDonationReceiptJob: tidak ada email tujuan", [
                'donasi_id' => $this->donasi->id,
            ]);
            return;
        }

        Mail::to($email)->send(new DonationReceipt($this->donasi));

        Log::info("Bukti donasi terkirim ke {$email}", [
            'donasi_id'       => $this->donasi->id,
            'kode_transaksi'  => $this->donasi->kode_transaksi,
        ]);
    }

    /**
     * Tangani kegagalan job.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Gagal mengirim bukti donasi: {$exception->getMessage()}", [
            'donasi_id'       => $this->donasi->id,
            'kode_transaksi'  => $this->donasi->kode_transaksi,
        ]);
    }
}
