<?php

namespace App\Mail;

use App\Models\Propiedad;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropiedadCreadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Propiedad $propiedad) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva propiedad cargada: ' . $this->propiedad->titulo,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.propiedad-creada',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}