<?php

namespace App\Http\Livewire\Resources\Screenings;

use App\Models\Screening;
use App\Services\Resources\SeatService;
use Livewire\Component;

class SeatMap extends Component
{
    public $takenSeats = [];
    public $selectedSeats = [];
    public Screening $screening;

    protected $listeners =
    [
        'resetSelectedSeats' => 'resetSelectedSeats',
        'conflict' => 'conflict',
    ];

    public function mount(SeatService $seatService)
    {
        $this->takenSeats = $seatService->getTakenSeatsMap($this->screening);
    }

    public function render()
    {
        return view('livewire.resources.screenings.seat-map');
    }

    /**
     * @param $conflicts
     * @param SeatService $seatService
     * Removes the conflicting seats from the selected seats
     * emits an event to sync the seats with the ticket
     * flashes the conflicts to the session
     */
    public function conflict($conflicts, SeatService $seatService): void
    {
        $this->selectedSeats = array_filter($this->selectedSeats, function ($selectedSeat) use ($conflicts) {
            return !in_array($selectedSeat, array_map(fn($seat) => [$seat['row'], $seat['column']], $conflicts), true);
        });

        $this->takenSeats = $seatService->getTakenSeatsMap($this->screening);

        $this->emit('syncSeats', collect($this->selectedSeats)->map(function ($seat) {
            return ['row' => $seat[0], 'column' => $seat[1]];
        }));

        session()->flash('conflicts', $conflicts);
    }

    public function resetSelectedSeats() : void
    {
        $this->selectedSeats = [];
        $this->render();
    }

    /**
     * @param $row
     * @param $column
     * Toggles a seat in the selected seats array
     * emits an event to sync the seats with the ticket
     */
    public function toggleSeat($row, $column) : void
    {
        $seat = [$row, $column];
        if ($this->isSelected($row, $column)) {
            $this->selectedSeats = array_filter($this->selectedSeats, fn($s) => $s !== $seat);
            $this->emit('seatDeselected', $row, $column);
        } else {
            $this->selectedSeats[] = $seat;
            $this->emit('seatSelected', $row, $column);
        }
    }

    public function isSelected($row, $column) : bool
    {
        return in_array([$row, $column], $this->selectedSeats);
    }

}
