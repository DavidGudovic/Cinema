<?php

namespace App\Services\Resources;

use App\Models\Booking;
use App\Models\Hall;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class HallService
{
    /**
     * Get all halls.
     *
     * @param int $manager_id
     * @return EloquentCollection
     */
    public function getHalls(int $manager_id = 0): EloquentCollection
    {
        return Hall::managedBy($manager_id)->get();
    }

    /**
     * Returns a map of unavailable time intervals for a hall for the given $dates
     * [[start_time, end_time], [start_time, end_time], ...]
     *
     * @param array $dates
     * @param Hall $hall
     * @return array
     */
    public function getUnavailableTimeSlotsForDaysMap(array $dates, Hall $hall): array
    {
        $screening_unavailable = Screening::fromHall($hall->id)
            ->fromDates($dates)
            ->select(['start_time', 'end_time'])
            ->get()
            ->map(function ($item) {
                return [$item->start_time, $item->end_time];
            })->toArray();

        $booking_unavailable = Booking::fromHall($hall->id)
            ->status('accepted')
            ->fromDates($dates)
            ->select(['start_time', 'end_time'])
            ->get()
            ->map(function ($item) {
                return [$item->start_time, $item->end_time];
            })->toArray();


        return array_merge($screening_unavailable, $booking_unavailable);
    }

    /**
     * Get an associative array of halls available at $start_time for the next $for_days.
     * [Date => [Hall, Hall, Hall...]...]
     *
     * @param $start_time
     * @param $end_time
     * @param $for_days
     * @return Collection
     */
    public function getAvailableHallsForDateMap($start_time, $end_time, $for_days): Collection
    {
        $screening_map = $this->getHallDatesMapForRelationship('screenings', $start_time, $end_time, $for_days);
        $booking_map = $this->getHallDatesMapForRelationship('bookings', $start_time, $end_time, $for_days);

        return collect($screening_map)->intersectByKeys($booking_map)->map(function ($dates, $hall) use ($booking_map) {
            return $dates->intersect($booking_map[$hall]);
        });
    }

    /**
     * Used to get arrays for bookings and screenings that is merged on intersect  in getAvailableDatesMap().
     *
     * @param $relationship
     * @param $start_time
     * @param $end_time
     * @param $for_days
     * @return array
     */
    private function getHallDatesMapForRelationship($relationship, $start_time, $end_time, $for_days): array
    {
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
                })->get();

            $startDate->addDay();
            $endDate->addDay();
        }

        return $map;
    }


}
