<?php

namespace App\Http\Livewire\Users\Business\Reclamations;

use App\Services\ReclamationService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;


    protected function paginationView(){
        return 'pagination.custom';
    }

    protected $listeners = [
        'ReclamationCancelled' => 'refresh',
        'setReclamationFilters' => 'setReclamationFilters',
    ];

    public $status_filter = "all";
    public $type_filter = 0;

    public function refresh(){
        $this->resetPage();
    }

    public function render(ReclamationService $reclamationService)
    {
        return view('livewire.users.business.reclamations.index', [
            'reclamations' => $reclamationService->getFilteredReclamationsPaginated($this->status_filter,$this->type_filter),
        ]);
    }


        /*
    Applies status and type filter
    Filter passed by event raised outside of Livewire
    */
    public function setReclamationFilters($status, $type): void
    {
        $this->status_filter = $status;
        $this->type_filter = $type;
        $this->resetPage();
    }

        /*
    Shows the modal for cancelling Request
    */
    public function cancelReclamation($reclamation_id): void
    {
        $this->emitTo('users.business.reclamations.delete-modal', 'showModal', $reclamation_id);
    }


}
