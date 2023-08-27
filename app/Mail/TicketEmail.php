<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;
    public $username;
    public $title;
    public $link;
    /**
    * Create a new message instance.
    */

    public function __construct(string $username, string $title, User $user, Ticket $ticket)
    {
        $this->username = $username;
        $this->title = $title;
        $this->link = route('user.tickets.print', ['user' => $user, 'ticket' => $ticket]);
    }
    /**
    * Get the message envelope.
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vaša karta',
        );
    }

    /**
    * Get the message content definition.
    */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.ticket',
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
