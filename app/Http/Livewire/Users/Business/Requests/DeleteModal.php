<?php

namespace App\Http\Livewire\Users\Business\Requests;

use Livewire\Component;
use App\Services\TicketService;
use App\Http\Livewire\ModalBase;
use App\Services\RequestableService;
use App\Models\BusinessRequest;
/**
* This component is used to display the delete modal for tickets
*/
class DeleteModal extends ModalBase
{
    public BusinessRequest $request_for_deletion;

    /**
    * Extracts request from ...$params of ModalBase
    */
    public function render(RequestableService $requestableService)
    {
        if (isset($this->params[0])) {
            $this->request_for_deletion = $requestableService->getRequest($this->params[0]);
        }
        return view('livewire.users.business.requests.delete-modal');
    }

    /**
    * Cancels request, flashes message to the modal and emits event to the parent component
    */
    public function cancelRequest(RequestableService $requestableService): void
    {
        $requestableService->cancelRequest($this->request_for_deletion);
        session()->flash('success','Uspešno ste otkazali zahtev');
        $this->emit('RequestCancelled');
    }
}
