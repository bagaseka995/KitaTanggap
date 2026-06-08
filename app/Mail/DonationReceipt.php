<?php

namespace App\Mail;

use App\Models\Donasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Donasi $donasi) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Donasi Anda — KitaTanggap',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation-receipt',
            with: [
                'nama_donatur'    => $this->donasi->nama_donatur,
                'email_donatur'   => $this->donasi->email_donatur,
                'nominal'         => $this->donasi->nominal_formatted,
                'kode_transaksi'  => $this->donasi->kode_transaksi,
                'metode'          => $this->donasi->label_metode,
                'tanggal'         => $this->donasi->updated_at->format('d F Y, H:i'),
                'nama_bencana'    => $this->donasi->bencana->nama_bencana ?? '-',
                'lokasi_bencana'  => $this->donasi->bencana->lokasi ?? '-',
                'pesan'           => $this->donasi->pesan,
            ],
        );
    }
}
