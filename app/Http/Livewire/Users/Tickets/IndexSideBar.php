<?php

namespace App\Http\Livewire\Users\Tickets;

use App\Http\Livewire\SidebarBase;
use App\Services\Resources\TicketService;
use Livewire\WithPagination;

/*
* This component is used to display the global sidebar for active tickets index
*/
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
            'tickets' => $ticketService->getFilteredTicketsPaginated(0, 'active', 1),
            'user' => auth()->user()
        ]);
    }
}
