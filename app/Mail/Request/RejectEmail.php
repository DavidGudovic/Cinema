<?php

namespace App\Mail\Request;

use App\Models\BusinessRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public bool $is_advert;
    public function __construct(public BusinessRequest $businessRequest)
    {
        $this->is_advert = $businessRequest->requestable_type === 'App\Models\Advert';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Zahtev odbijen',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.request.reject',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
