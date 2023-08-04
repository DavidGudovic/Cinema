<?php
namespace App\Services;

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
        return Ticket::with('screening.movie')->withTrashed()->findOrFail($id);
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
    * Todo find cleaner way - ugly wall of code
    */
    public function getFilteredTicketsPaginated(string $status = 'all', int $movie, ?int $quantity = 2) : LengthAwarePaginator
    {
        return Ticket::with('screening.movie')
        ->where('user_id', auth()->user()->id)
        ->when($status == 'all', function($query){
            return $query->withTrashed();
        })->when($status == 'active', function($query){
            return $query->active();
        })->when($status == 'cancelled', function($query){
            return $query->onlyTrashed();
        })->when($status == 'inactive', function($query){
            return $query->inactive();
        })->when($movie != 0, function($query) use ($movie){
            return $query->forMovie($movie);
        })
        ->orderBy('created_at', 'desc')
        ->paginate($quantity);
    }
}
