<?php

namespace App\Http\Livewire\Resources\Screenings\Ticket;

use App\Models\Screening;
use App\Models\Seat;
use App\Models\Ticket;
use App\Services\ScreeningService;
use App\Services\SeatService;
use App\Services\TicketService;
use Livewire\Component;

class Create extends Component
{
    public Screening $screening;
    public Ticket $ticket;
    public $seats;

    protected $listeners =
        [
            'seatSelected' => 'seatSelected',
            'seatDeselected' => 'seatDeselected',
            'syncSeats' => 'syncSeats',
        ];

    public function mount(ScreeningService $screeningService): void
    {
        $this->screening = $screeningService->eagerLoadScreening($this->screening->id);
        $this->ticket = new Ticket();
        $this->seats = collect();
    }

    public function render()
    {
        $this->setRelations();
        return view('livewire.resources.screenings.ticket.create');
    }

    /**
     *  Syncs the seats with the seat map
     */
    public function syncSeats($seats)
    {
        $this->seats = collect($seats);
    }

    /**
     *  Sets the relations for the ticket model
     *  Livewire resets state on every hydrate, so the relations need to be reset on every request afaik
     */
    public function setRelations(): void
    {
        $this->ticket->setRelation('seats', $this->seats);
        $this->ticket->setRelation('screening', $this->screening);
    }

    /**
     *  listens for event from livewire.resources.screenings.seat-map component
     */
    public function seatSelected($row, $column): void
    {
        $this->seats->push(new Seat(['row' => $row, 'column' => $column]));
        $this->render();
    }


    /**
     *  listens for event from livewire.resources.screenings.seat-map component
     */
    public function seatDeselected($row, $column): void
    {
        $this->seats = $this->seats->reject(function ($seat) use ($row, $column) {
            return $seat['row'] == $row && $seat['column'] == $column;
        })->values();
    }

    /**
     * Emits to SeatMap component to reset the selected seats
     */
    public function resetSelectedSeats(): void
    {
        $this->seats = collect();
        $this->emit('resetSelectedSeats');
    }

    /**
     *  Handles the creation of a ticket and redirects to TicketController@show
     */
    public function store(TicketService $ticketService, SeatService $seatService)
    {
        $this->setRelations();

        $conflicts = $seatService->checkHasConflicts($this->seats, $this->screening);

        if ($conflicts) { // if there are conflicts, emit to SeatMap component to highlight the conflicting seats
            $this->emit('conflict', $conflicts);
        } else {
            $ticket_final = $ticketService->createTicket($this->ticket);
            $this->emit('ticketCreated');
            return redirect()->route('user.tickets.show', ['user' => auth()->user(), 'ticket' => $ticket_final]);
        }
    }
}

