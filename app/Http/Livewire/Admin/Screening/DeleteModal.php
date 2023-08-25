<?php

namespace App\Http\Livewire\Admin\Screening;

use App\Http\Livewire\ModalBase;
use App\Jobs\UnscheduleAdverts;
use App\Models\Screening;
use App\Services\ScreeningService;
use Illuminate\Support\Collection;

class DeleteModal extends ModalBase
{
    public Collection $screening;
    public function render()
    {
        if(isset($this->params[0])){
            $this->screening = collect($this->params[0]);
        }


        return view('livewire.admin.screening.delete-modal');
    }

    public function deleteScreening(ScreeningService $screeningService): void
    {
        $screeningService->cancelScreening($this->screening['id']);
        session()->flash('success','Uspešno ste izbrisali projekciju');
        $this->emit('ScreeningDeleted');
    }
}