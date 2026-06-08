<?php

namespace App\Mail;

use App\Models\Penugasan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PenugasanRelawanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Penugasan $penugasan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Penugasan Misi Kemanusiaan Baru - KitaTanggap',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.penugasan_relawan',
            with: [
                'nama'          => $this->penugasan->relawan->user->nama_lengkap,
                'nama_bencana'  => $this->penugasan->bencana->nama_bencana,
                'lokasi'        => $this->penugasan->bencana->lokasi,
                'tanggal_tugas' => $this->penugasan->tanggal_tugas->format('d-m-Y'),
                'catatan'       => $this->penugasan->catatan,
                'link_riwayat'  => route('relawan.riwayat.index'),
            ],
        );
    }
}
