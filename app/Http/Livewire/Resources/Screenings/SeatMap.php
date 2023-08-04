<?php

namespace App\Http\Livewire\Resources\Screenings;

use Livewire\Component;
use App\Models\Screening;
use App\Services\SeatService;

class SeatMap extends Component
{
    public $takenSeats = [];
    public $selectedSeats = [];
    public Screening $screening;

    public function mount(SeatService $seatService)
    {
        $this->takenSeats = $seatService->getTakenSeatsMap($this->screening);
    }

    public function render()
    {
        return view('livewire.resources.screenings.seat-map');
    }

    public function toggleSeat($row, $column)
    {
        $seat = [$row, $column];
        if (in_array($seat, $this->selectedSeats)) {
            $this->selectedSeats = array_filter($this->selectedSeats, fn($s) => $s !== $seat);
        } else {
            $this->selectedSeats[] = $seat;
        }
    }

    public function isSelected($row, $column)
    {
        return in_array([$row, $column], $this->selectedSeats);
    }

}
