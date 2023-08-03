<?php

namespace App\Http\Livewire\Users\Tickets;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\TicketService;

class Index extends Component
{
    use WithPagination;
    public $status_filter = "";
    public $movie_filter = 0;

    public $listeners = [
        'setTicketFilters' => 'setTicketFilters',
        'cancelTicket' => 'cancelTicket',
    ];

    public function paginationView()
    {
        return 'pagination.custom';
    }

    public function render()
    {
        return view('livewire.users.tickets.index', [
            'tickets' => auth()->user()->tickets()->with('screening.movie')->paginate(2),
        ]);
    }

    /*
    Applies status and movie filter
    Filter passed by event raised outside of Livewire
    */
    public function setTicketFilters($status, $movie): void
    {
        $this->status_filter = $status;
        $this->movie_filter = $movie;
        $this->resetPage();
    }

    /*
    Calls TicketServices to cancel an Ticket
    */
    public function cancelTicket(Ticket $ticket, TicketService $ticketService) : void
    {
        $ticketService->cancelTicket($ticket);
    }
}
