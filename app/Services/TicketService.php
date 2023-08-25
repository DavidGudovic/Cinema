<?php

namespace App\Services;

use App\Mail\TicketEmail;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDF;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class TicketService
{


    /**
     * @param User $user
     * @param Ticket $ticket
     * @return DomPDF
     * Get a PDF of a ticket
     */
    public function getTicketPDF(User $user, Ticket $ticket): DomPDF
    {
        return PDF::loadView('pdf.ticket', [
            'ticket' => $ticket,
            'user' => $user,
            'movie' => $ticket->screening->movie,
            'screening' => $ticket->screening,
            'seats' => $ticket->seats
        ])
            ->setPaper('a5', 'landscape');
    }

    /**
     * @param int $id
     * @return Ticket
     * Get a ticket by id
     */
    public function getTicket(int $id): Ticket
    {
        return Ticket::with('screening.movie')->with('seats')
            ->withTrashed()
            ->findOrFail($id);
    }

    /**
     * @param User $user
     * @return EloquentCollection
     * Get all tickets for a user
     */
    public function getUsersTickets(User $user): EloquentCollection
    {
        return $user->tickets()
            ->with('screening')
            ->get();
    }

    /**
     * @param User $user
     * @return Collection
     * Get all unique movies a user has purchased a ticket for
     */
    public function getUniqueMovies(User $user): Collection
    {
        return $user->tickets()
            ->withTrashed()
            ->with('screening.movie')
            ->get()
            ->pluck('screening.movie')
            ->unique();
    }

    /**
     * @param Ticket $ticket
     * @return void
     * Soft deletes Ticket
     */
    public function cancelTicket(Ticket $ticket): void
    {
        $ticket->delete();
    }

    /**
     * @param int $movie
     * @param string $status
     * @param int|null $quantity
     * @return LengthAwarePaginator
     * Get all tickets for a user with optional filters, paginated
     */
    public function getFilteredTicketsPaginated(int $movie, string $status = 'all', ?int $quantity = 2): LengthAwarePaginator
    {
        return Ticket::with('screening.movie')->with('seats')
            ->forUser(auth()->user())
            ->filterByStatus($status)
            ->filterByMovie($movie)
            ->orderBy('created_at', 'desc')
            ->paginate($quantity);
    }

    /**
     * @param Ticket $ticket
     * @return Ticket
     * Gets passed an in-memory instance of a ticket model and creates a ticket with seats in the database
     */
    public function createTicket(Ticket $ticket): Ticket
    {
        $ticket->user_id = auth()->user()->id;
        $ticket->screening_id = $ticket->screening->id;
        $ticket->save();

        foreach ($ticket->seats as $seat) {
            Seat::create([
                'ticket_id' => $ticket->id,
                'row' => $seat['row'],
                'column' => $seat['column']
            ]);
        }
        return $ticket;
    }

    /**
     * @param User $user
     * @param Ticket $ticket
     * @return void
     * Sends an Email to the user with the ticket
     */
    public function sendTicketEmail(User $user, Ticket $ticket): void
    {
        $mailable = new TicketEmail($user->username, $ticket->screening->movie->title, $user, $ticket);
        Mail::to($user->email)->send($mailable);
    }

}
