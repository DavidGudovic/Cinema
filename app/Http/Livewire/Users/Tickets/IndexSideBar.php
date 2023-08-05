<?php

namespace App\Http\Livewire\Users\Tickets;

use Livewire\Component;
use App\Services\TicketService;
use App\Http\Livewire\SidebarBase;
use Livewire\WithPagination;

class IndexSideBar extends SidebarBase
{
    use WithPagination;

    public function paginationView()
    {
        return 'pagination.custom';
    }

    public function render(TicketService $ticketService)
    {

        return view('livewire.users.tickets.index-side-bar', [
            'tickets' => $ticketService->getFilteredTicketsPaginated('active', 0, 1),
            'user' => auth()->user()
        ]);
    }

    /*
    * Cancels ticket, flashes message to the modal and emits event to the parent component
    */
    public function cancelTicket(TicketService $ticketService)
    {
        $ticketService->cancelTicket($this->ticket);
        session()->flash('success','Uspešno ste otkazali kartu');
        $this->emit('ticketCancelled');
    }
}
