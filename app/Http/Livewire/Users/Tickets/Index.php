<?php

namespace App\Http\Livewire\Users\Tickets;

use App\Models\Ticket;
use App\Services\Resources\TicketService;
use Livewire\Component;
use Livewire\WithPagination;

/*
* This component is used to display the tickets index
*/
class Index extends Component
{
    use WithPagination;
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

    public function paginationView()
    {
        return 'pagination.custom';
    }

    public function render(TicketService $ticketService)
    {
        return view('livewire.users.tickets.index', [
            'tickets' => $ticketService->getFilteredTicketsPaginated($this->movie_filter,$this->status_filter),
            'user' => auth()->user()
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
