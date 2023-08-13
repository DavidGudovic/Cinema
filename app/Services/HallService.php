<?php
namespace App\Services;

use App\Models\Hall;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Nette\NotImplementedException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/*
* Services for App/Models/Halls.php
*/
class HallService {
    /*
    * Get all halls.
    */
    public function getHalls() : EloquentCollection {
        return Hall::all();
    }

    /*
    * Get an associative array of halls available at $start_time for the next $for_days.
    * [Date => [Hall, Hall, Hall..]..]
    */
    public function getAvailableHallsForDateMap($start_time, $end_time, $for_days) : Collection {
        $screening_map = $this->getAvailableDatesForHallMap('screenings', $start_time, $end_time, $for_days);
        $booking_map = $this->getAvailableDatesForHallMap('bookings', $start_time, $end_time, $for_days);

        return collect($screening_map)->intersectByKeys($booking_map)->map(function ($dates, $hall) use ($booking_map) {
            return $dates->intersect($booking_map[$hall]);
        });
    }

    /*
    * Gets an associative array of dates a hall doesn't have bookings/screenings ($relationship interchangeable) at $start_time for the next $for_days.
    * [Hall => [Date, Date, Date..]..
    * Used to get arrays for bookings and screenings that is merged on intersect and rekeyed in getAvailableDatesMap().
    */
    private function getAvailableDatesForHallMap($relationship, $start_time, $end_time, $for_days) : array {
        $map = [];
        $startDate = clone $start_time;  // clone to avoid modifying the original object
        $endDate = clone $end_time;

        for ($i = 0; $i < $for_days; $i++) {    // from start_time to start_time + $for_days
            $formattedDate = $startDate->format('Y-m-d');
            $map[$formattedDate] =
            Hall::whereDoesntHave($relationship, function ($query) use ($formattedDate, $startDate, $endDate, $relationship) {
                $query->whereDate('start_time', $formattedDate)
                ->overlapsWithTime($startDate, $endDate)
                ->when($relationship == 'bookings', function ($query) {
                    return $query->pendingOrAccepted(); // Cancelled and rejected requests shouldn't be counted as unavailable
                });
            }) ->get();

            $startDate->addDay();
            $endDate->addDay();
        }

        return $map;
    }


}
