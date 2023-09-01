<?php

namespace App\Mail\Reclamation;

use App\Models\Reclamation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public function __construct(public Reclamation $reclamation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reklamacija odbijena',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reclamation.reject',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
