<?php

namespace App\Mail\Request;

use App\Models\BusinessRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcceptEmail extends Mailable implements ShouldQueue
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
            subject: 'Zahtev prihvaćen',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.request.accept',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
