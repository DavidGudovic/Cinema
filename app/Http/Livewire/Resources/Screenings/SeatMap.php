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

    protected $listeners =
    [
        'resetSelectedSeats' => 'resetSelectedSeats',
    ];

    public function mount(SeatService $seatService)
    {
        $this->takenSeats = $seatService->getTakenSeatsMap($this->screening);
    }

    public function render()
    {
        return view('livewire.resources.screenings.seat-map');
    }

    public function resetSelectedSeats() : void
    {
        $this->selectedSeats = [];
        $this->render();
    }

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
