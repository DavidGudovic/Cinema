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
    * [Hall => [Date, Date, Date..]..]
    */
    public function getAvailableDatesMap($start_time, $end_time, $for_days) : Collection {

        $screening_map = $this->getHallsWithoutMap('screenings', $start_time, $end_time, $for_days);
        $booking_map = $this->getHallsWithoutMap('bookings', $start_time, $end_time, $for_days);
        $matching_keys = array_keys(array_intersect_key($booking_map, $screening_map));
        // Merge the two arrays on intersects, remove duplicates and remap to Hall as key, date array as value
        return collect($matching_keys)->mapWithKeys(function ($key) use ($booking_map, $screening_map) {
            return [$key => $booking_map[$key]->intersect($screening_map[$key])];
        });
    }
    /*
    * Gets an assoc array of halls without booking/screening for the next $for_days at $start_time - $end_time
    * [Date => [Hall, Hall, Hall..]..]
    */
    private function getHallsWithoutMap($relationship, $start_time, $end_time, $for_days) : array {
        $map = [];
        $start_time = clone $start_time;
        $end_time = clone $end_time;
        $date = $start_time->format('Y-m-d');

        for ($i = 0; $i < $for_days; $i++) {
            $map[$date] = Hall::whereDoesntHave($relationship, function ($query) use ($start_time, $end_time, $date) {
                $query->whereDate('start_time', $date)
                ->overlapsWithTime($start_time, $end_time);
            })->get();

            $start_time = $start_time->addDays(1);
            $end_time = $end_time->addDays(1);
            $date = Carbon::parse($date)->addDays(1)->format('Y-m-d');
        }
        return $map;
    }

}
