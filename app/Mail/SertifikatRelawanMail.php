<?php

namespace App\Mail;

use App\Models\Sertifikat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SertifikatRelawanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Sertifikat $sertifikat) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sertifikat Partisipasi Relawan KitaTanggap',
        );
    }

    public function content(): Content
    {
        // Load related data
        $penugasan = $this->sertifikat->penugasan;
        $relawan = $penugasan->relawan;
        $bencana = $penugasan->bencana;

        return new Content(
            view: 'emails.sertifikat_relawan',
            with: [
                'nama'            => $relawan->user->nama_lengkap,
                'nama_bencana'    => $bencana->nama_bencana,
                'kode_sertifikat' => $this->sertifikat->kode_sertifikat,
                'link_verifikasi' => url("/verifikasi/{$this->sertifikat->kode_sertifikat}"),
            ],
        );
    }

    public function attachments(): array
    {
        // Pastikan path absolut file valid di server
        $path = public_path($this->sertifikat->file_path);

        return [
            Attachment::fromPath($path)
                ->as("Sertifikat-{$this->sertifikat->kode_sertifikat}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
