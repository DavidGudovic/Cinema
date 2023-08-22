<?php
namespace App\Services;

use App\Models\Ticket;
use App\Models\Seat;
use App\Models\Screening;
use Illuminate\Support\Collection;
use Nette\NotImplementedException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class SeatService
{
    public function checkHasConflicts($seats, Screening $screening): bool|array
    {
        $takenSeats = $this->getTakenSeatsMap($screening);
        $conflicts = [];

        foreach ($seats as $seat) {
            if (in_array([$seat['row'], $seat['column']], $takenSeats)) {
                $conflicts[] = $seat;
            }
        }

        return empty($conflicts) ? false : $conflicts;
    }

    /**
    * Returns an array of taken seats for a screening
    * [ [row, column], [row, column], ... ]
    */
    public function getTakenSeatsMap(Screening $screening): array
    {
        return Seat::inScreening($screening)
        ->get()
        ->map(fn($seat) => [$seat->row, $seat->column])
        ->all();
    }
}
