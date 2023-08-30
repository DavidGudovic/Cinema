<?php

namespace App\Http\Livewire\Users\Tickets;

use App\Models\Ticket;
use App\Services\Resources\TicketService;
use App\Traits\WithCustomPagination;
use Livewire\Component;

class Index extends Component
{
    use WithCustomPagination;

    public $status_filter = "all";
    public $movie_filter = 0;

    public $listeners = [
        'setTicketFilters' => 'setTicketFilters',
        'cancelTicket' => 'cancelTicket',
        'ticketCancelled' => 'refresh'
    ];

    public function refresh()
    {
    }

    public function render(TicketService $ticketService)
    {
        return view('livewire.users.tickets.index', [
            'tickets' => $ticketService->getFilteredTicketsPaginated($this->movie_filter, $this->status_filter),
            'user' => auth()->user()
        ]);
    }

    /**
     * Applies status and movie filter
     * passed by event raised outside Livewire
     */
    public function setTicketFilters($status, $movie): void
    {
        $this->status_filter = $status;
        $this->movie_filter = $movie;
        $this->resetPage();
    }

    /**
     * Calls TicketServices to cancel a Ticket
     */
    public function cancelTicket(Ticket $ticket, TicketService $ticketService): void
    {
        $ticketService->cancelTicket($ticket);
    }
}
