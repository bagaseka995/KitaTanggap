<?php

namespace App\Mail;

use App\Models\Relawan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PenolakanRelawanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Relawan $relawan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Pendaftaran Relawan KitaTanggap',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.relawan.penolakan',
            with: [
                'nama'   => $this->relawan->user->nama_lengkap,
                'email'  => $this->relawan->user->email,
            ],
        );
    }
}
