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
    public $seats;

    protected $listeners =
    [
        'seatSelected' => 'seatSelected',
        'seatDeselected' => 'seatDeselected',
    ];

    public function mount(ScreeningService $screeningService)
    {
        $this->screening = $screeningService->eagerLoadScreening($this->screening->id);
        $this->ticket = new Ticket();
        $this->seats = collect();
    }

    public function render()
    {
        $this->ticket->setRelation('seats', $this->seats);
        $this->ticket->setRelation('screening', $this->screening);
        return view('livewire.resources.screenings.ticket.create');
    }

    /*
    *  listens for event from livewire.resources.screenings.seat-map component
    */
    public function seatSelected($row, $column)
    {
        $this->seats->push(new Seat(['row' => $row, 'column' => $column]));
        $this->render();
    }


    /*
    *  listens for event from livewire.resources.screenings.seat-map component
    */
    public function seatDeselected($row, $column)
    {
        $this->seats = $this->seats->reject(function ($seat) use ($row, $column) {
            return $seat['row'] == $row && $seat['column'] == $column;
        })->values();
    }

    /*
     Emits to SeatMap component to reset the selected seats
    */
    public function resetSelectedSeats()
    {
        $this->seats = collect();
        $this->emit('resetSelectedSeats');
    }
}

