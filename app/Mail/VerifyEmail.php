<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $link;
    /**
    * Create a new message instance.
    */
    public function __construct(protected $id, protected $email)
    {
        $this->link = URL::temporarySignedRoute(
            'verify.update',
            now()->addMinutes(60),
            ['id' => $this->id, 'email' => sha1($this->email)]
        );
    }

    /**
    * Get the message envelope.
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Potvrdite email adresu',
        );
    }

    /**
    * Get the message content definition.
    */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.verify-email',
            with: [
                'link' => $this->link,
                ]
            );
        }

        /**
        * Get the attachments for the message.
        *
        * @return array<int, \Illuminate\Mail\Mailables\Attachment>
        */
        public function attachments(): array
        {
            return [];
        }
    }
