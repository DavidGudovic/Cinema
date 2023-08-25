<?php

namespace App\Http\Livewire\Users\Business\Requests;

use App\Models\Advert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\TicketService;
use App\Http\Livewire\SidebarBase;
use App\Services\RequestableService;

/**
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
        $requests = $requestablesService->getFilteredRequestsPaginated('accepted', 0, 1);

        if($requests[0] && $requests[0]->requestable instanceof Advert){  // Workaround for Livewire not being able to refresh chart reactive keys
            $this->emit('refreshChart', $requests[0]->requestable);
        }

        return view('livewire.users.business.requests.index-sidebar', [
            'requestables' => $requests,
            'user' => auth()->user()
        ]);
    }
}

