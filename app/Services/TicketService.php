<?php
namespace App\Services;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TicketService{
    /*
    * Get all tickets for a user
    */
    public function getUsersTickets(User $user) : EloquentCollection
    {
        return $user->tickets()->with('screening')->get();
    }

    /*
    * Get all unique movies a user has purchased a ticket for
    */
    public function getUniqueMovies(User $user){
        return $user->tickets()->with('screening.movie')->get()->pluck('screening.movie')->unique();
    }

    public function cancelTicket(Ticket $ticket) : void
    {
        $ticket->softDelete();
    }
}
