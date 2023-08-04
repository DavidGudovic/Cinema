<?php

namespace App\Http\Livewire\Resources\Screenings\Ticket;

use App\Models\Seat;
use App\Models\Ticket;
use Livewire\Component;
use App\Models\Screening;
use App\Services\ScreeningService;

class Create extends Component
{
    public Screening $screening;
    public Ticket $ticket;


    protected $listeners =
    [
        'seatSelected' => 'seatSelected',
        'seatDeselected' => 'seatDeselected',
    ];

    public function mount(ScreeningService $screeningService)
    {
        $this->screening = $screeningService->eagerLoadScreening($this->screening->id);
        $this->ticket = new Ticket();
        $this->ticket->seats = collect();
        $this->ticket->screening()->associate($this->screening);
    }

    public function render()
    {
        $this->ticket->setRelation('screening', $this->screening);
        return view('livewire.resources.screenings.ticket.create');
    }

    public function seatSelected($row, $column)
    {
        $this->ticket->seats->push(new Seat(['row' => $row, 'column' => $column]));
        $this->render();
    }

    public function seatDeselected($row, $column)
    {
        $this->ticket->seats = $this->ticket->seats->reject(function ($seat) use ($row, $column) {
            return $seat->row == $row && $seat->column == $column;
        });
    }
}
