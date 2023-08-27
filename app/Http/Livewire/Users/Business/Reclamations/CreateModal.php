<?php

namespace App\Http\Livewire\Users\Business\Reclamations;

use App\Http\Livewire\ModalBase;
use App\Services\Resources\ReclamationService;

class CreateModal extends ModalBase
{
    public int $request;
    public $text;

    /**
    * Extracts request from ...$params of ModalBase
    */
    public function render()
    {
        if (isset($this->params[0])) {
            $this->request = $this->params[0];
        }
        return view('livewire.users.business.reclamations.create-modal');
    }

    /**
    * Stores a reclamation for a request
    */
    public function store(ReclamationService $reclamationService): void
    {
        if($this->text == null){
            session()->flash('message','Morate uneti tekst reklamacije');
            return;
        }

        $reclamationService->storeReclamation($this->request, $this->text);
        session()->flash('message','Uspešno ste poslali reklamaciju');
        $this->emit('ReclamationCreated');
    }
}
