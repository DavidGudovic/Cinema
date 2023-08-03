<?php

namespace App\Http\Livewire\Users\Tickets;

use App\Http\Livewire\ModalBase;
use App\Models\Ticket;
use App\Services\TicketService;

class DeleteModal extends ModalBase
{
    public Ticket $ticket;

    public function render(TicketService $ticketService)
    {
        if (isset($this->params[0])) {
            $this->ticket = $ticketService->getTicket($this->params[0]);
        }
        return view('livewire.users.tickets.delete-modal');
    }

    public function cancelTicket(TicketService $ticketService)
    {
        $ticketService->cancelTicket($this->ticket);
        session()->flash('success','Uspešno ste otkazali kartu');
        $this->emit('ticketCancelled');
    }
}
