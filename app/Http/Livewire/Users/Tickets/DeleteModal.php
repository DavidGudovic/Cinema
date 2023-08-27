<?php

namespace App\Http\Livewire\Users\Tickets;

use App\Http\Livewire\ModalBase;
use App\Models\Ticket;
use App\Services\Resources\TicketService;

/*
* This component is used to display the delete modal for tickets
*/
class DeleteModal extends ModalBase
{
    public Ticket $ticket;

    /*
    * Extracts ticket from ...$params of ModalBase
    */
    public function render(TicketService $ticketService)
    {
        if (isset($this->params[0])) {
            $this->ticket = $ticketService->getTicket($this->params[0]);
        }
        return view('livewire.users.tickets.delete-modal');
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
