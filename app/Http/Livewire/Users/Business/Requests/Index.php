<?php

namespace App\Http\Livewire\Users\Business\Requests;

use App\Services\AdvertService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\RequestableService;
use App\Models\Advert;

class Index extends Component
{
    use WithPagination;

    public $status_filter = "all";
    public $type_filter = 0;

    public $listeners = [
        'setRequestFilters' => 'setRequestFilters',
        'cancelRequest' => 'cancelRequest',
        'RequestCancelled' => 'refresh',
        'ReclamationCreated' => 'refresh'
    ];

    public function refresh(){
    }

    public function paginationView()
    {
        return 'pagination.custom';
    }

    public function render(RequestableService $requestableService)
    {
        $requests = $requestableService->getFilteredRequestsPaginated($this->status_filter,$this->type_filter);

        if($requests[0] && $requests[0]->requestable instanceof Advert){  // Workaround for Livewire not being able to refresh chart reactive keys
            if($requests[0]['status'] != 'CANCELLED') { // Weird fix for an even weirder bug
                $this->emit('refreshChart', $requests[0]->requestable);
            }
        }

        return view('livewire.users.business.requests.index', [
            'requests' => $requests,
            'user' => auth()->user(),
        ]);
    }

    /*
    Applies status and type filter
    Filter passed by event raised outside of Livewire
    */
    public function setRequestFilters($status, $type): void
    {
        $this->status_filter = $status;
        $this->type_filter = $type;
        $this->resetPage();
    }

    /*
    Shows the modal for cancelling Request
    */
    public function cancelRequest($request_id): void
    {
        $this->emitTo('users.business.requests.delete-modal', 'showModal', $request_id);
    }

}
