<?php

namespace App\Http\Livewire\Users\Business\Reclamations;

use Livewire\Component;
use App\Http\Livewire\ModalBase;
use App\Services\ReclamationService;

class DeleteModal extends ModalBase
{
    public int $reclamation_for_deletion;

    public function render()
    {
        isset($this->params[0]) ?
            $this->reclamation_for_deletion = $this->params[0] : null;

        return view('livewire.users.business.reclamations.delete-modal');
    }

    /*
    * Cancels Reclamation, flashes message to the modal and emits event to the parent component
    */
    public function cancelReclamation(ReclamationService $reclamationService)
    {
        $reclamationService->cancelReclamation($this->reclamation_for_deletion);
        session()->flash('success','Uspešno ste otkazali reklamaciju');
        $this->emit('ReclamationCancelled');
    }
}
