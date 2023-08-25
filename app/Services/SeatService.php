<?php

namespace App\Services;

use App\Models\Screening;
use App\Models\Seat;

class SeatService
{
    /**
     * @param $seats
     * @param Screening $screening
     * @return bool|array
     *  Checks if there are conflicts with the passed seats and a screening
     *  If there are conflicts, returns an array of the conflicting seats
     */
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
     * @param Screening $screening
     * @return array
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
