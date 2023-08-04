<?php
namespace App\Services;

use App\Models\Seat;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TicketService{

    /*
    * Get a ticket by id
    */
    public function getTicket(int $id) : Ticket
    {
        return Ticket::with('screening.movie')->with('seats')
        ->withTrashed()
        ->findOrFail($id);
    }
    /*
    * Get all tickets for a user
    */
    public function getUsersTickets(User $user) : EloquentCollection
    {
        return $user->tickets()
        ->with('screening')
        ->get();
    }

    /*
    * Get all unique movies a user has purchased a ticket for
    */
    public function getUniqueMovies(User $user){
        return $user->tickets()
        ->withTrashed()
        ->with('screening.movie')
        ->get()
        ->pluck('screening.movie')
        ->unique();
    }

    /*
    Soft deletes Ticket
    */
    public function cancelTicket(Ticket $ticket) : void
    {
        $ticket->delete();
    }

    /*
    * Get all tickets for a user with optional filters, paginated
    *
    */
    public function getFilteredTicketsPaginated(string $status = 'all', int $movie, ?int $quantity = 2) : LengthAwarePaginator
    {
        return Ticket::with('screening.movie')->with('seats')->with('screening.tags') // <---------- with half the database
        ->where('user_id', auth()->user()->id)
        ->filterByStatus($status)
        ->filterByMovie($movie)
        ->orderBy('created_at', 'desc')
        ->paginate($quantity);
    }

    /*
    *  Gets passed an in-memory instance of a ticket model and creates a ticket with seats in the database
    */
    public function createTicket(Ticket $ticket) : Ticket
    {
        $ticket->user_id = auth()->user()->id;
        $ticket->screening_id = $ticket->screening->id;
        $ticket->save();

        foreach($ticket->seats as $seat){
            Seat::create([
                'ticket_id' => $ticket->id,
                'row' => $seat['row'],
                'column' => $seat['column']
            ]);
        }
        return $ticket;
    }

}
