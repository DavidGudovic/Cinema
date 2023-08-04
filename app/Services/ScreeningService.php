<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Movie;
use App\Models\Ticket;
use App\Models\Screening;
use Nette\NotImplementedException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/*
* Service for App\Models\Screening
*/
class ScreeningService
{
    /*
    * Returns an associative array of $quantity of screenings grouped by date for a movie
    * [Date => [Screening, Screening, ...]]
    */
    public function getScreeningsMapForMovie(Movie $movie, int $quantity) : EloquentCollection
    {
        return $movie->screenings()
        ->withOmmitedTag('Dolby Atmos')
        ->upcoming()
        ->orderBy('start_time')
        ->get()
        ->groupBy(function ($screening) {
            return Carbon::parse($screening->start_time)
            ->format('Y-m-d');
        })
        ->take($quantity);
    }

    /*
    * Returns an array of taken seats for a screening
    */
    public function getTakenSeats(Screening $screening): array
    {
        $tickets = Ticket::forScreening($screening)->get();
        $takenSeats = [];
        foreach ($tickets as $ticket) {
            $row = $ticket->first_seat_row;
            $column = $ticket->first_seat_column;
            $seatNumber = $ticket->seat_number;

            // Add the coordinates of the subsequent seats to the right
            for ($i = 0; $i <= $seatNumber - 1; $i++) {
                $takenSeats[] = [$row - 1, $column + $i];
            }
        }

        return $takenSeats;
    }


}
