<?php

namespace App\Http\Livewire\Users\Business\Requests;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\TicketService;
use App\Http\Livewire\SidebarBase;
use App\Services\RequestableService;

/*
* This component is used to display the global sidebar for active requests index
*/
class IndexSideBar extends SidebarBase
{
    use WithPagination;

    public function paginationView()
    {
        return 'pagination.custom';
    }

    public function render(RequestableService $requestablesService)
    {

        return view('livewire.users.business.requestabless.index-sidebarr', [
            'requestables' => $requestablesService->getFilteredRequestsPaginated('active', 0, 1),
            'user' => auth()->user()
        ]);
    }
}

