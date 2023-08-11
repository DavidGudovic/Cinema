<?php

namespace App\Http\Livewire\Users\Business\Requests;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\RequestableService;

class Index extends Component
{
   use WithPagination;

    public $status_filter = "all";
    public $type_filter = 0;

    public $listeners = [
        'setRequestFilters' => 'setRequestFilters',
        'cancelRequest' => 'cancelRequest',
        'RequestCancelled' => 'refresh'
    ];

    public function refresh()
    {
    }

    public function paginationView()
    {
        return 'pagination.custom';
    }

    public function render(RequestableService $requestableService)
    {
        return view('livewire.users.business.requests.index', [
            'requests' => $requestableService->getFilteredRequestsPaginated($this->status_filter,$this->type_filter),
            'user' => auth()->user()
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

}
