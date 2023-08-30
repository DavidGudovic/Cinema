<?php

namespace App\Http\Livewire\Users\Business\Requests;

use App\Http\Livewire\SidebarBase;
use App\Models\Advert;
use App\Services\Resources\RequestableService;
use App\Traits\WithCustomPagination;

/**
* This component is used to display the global sidebar for active requests index
*/
class IndexSideBar extends SidebarBase
{
    use WithCustomPagination;

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

