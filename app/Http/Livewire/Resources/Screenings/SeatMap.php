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
