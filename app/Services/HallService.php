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
        $booking_map = $this->getHallsWithoutMap('bookings', $start_time, $end_time, $for_days);
        $screening_map = $this->getHallsWithoutMap('screenings', $start_time, $end_time, $for_days);
        $matching_keys = array_keys(array_intersect_key($booking_map, $screening_map));

        // Merge the two arrays on intersects, remove duplicates and remap to Hall as key, date array as value
        return collect($matching_keys)->mapWithKeys(function ($key) use ($booking_map, $screening_map) {
            $merged_array = array_merge($booking_map[$key], $screening_map[$key]);
            $unique_values = collect($merged_array)->values()->unique();
            return [$key => $unique_values];
        });
    }
    /*
    * Gets an assoc array of halls without booking/screening for the next $for_days at $start_time - $end_time
    * [Date => [Hall, Hall, Hall..]..]
    */
    private function getHallsWithoutMap($relationship, $start_time, $end_time, $for_days) : array {
        $map = [];

        for ($i = 0; $i < $for_days; $i++) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $map[$date] = Hall::whereDoesntHave($relationship, function ($query) use ($start_time, $end_time, $date) {
                $query->whereDate('start_time', $date)
                ->overlapsWithTime($start_time, $end_time);
            })->get();
        }

        return $map;
    }

}
