<?php
namespace App\Services;

use App\Models\Ticket;
use App\Models\Seat;
use App\Models\Screening;
use Nette\NotImplementedException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class SeatService
{
    /*
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
