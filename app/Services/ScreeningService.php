<?php

namespace App\Services;

use App\Interfaces\CanExport;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/*
* Service for App\Models\Screening
*/

class ScreeningService implements CanExport
{

    /**
     * Returns a paginated, filtered list of screenings or a searched through list of screenings if $this->search_query is set
     * All parameters are optional, if none are passed, all screenings are returned
     */
    public function getFilteredScreeningsPaginated(string $time = 'any', int $hall_id = 0, int $movie_id = 0, string $search_query = '', bool $do_sort = false, string $sort_by = 'title', string $sort_direction = 'ASC', int $quantity = 10): LengthAwarePaginator|Collection
    {
        return Screening::with('movie', 'hall')->withCount('tickets')->withCount('adverts')
            ->time($time)
            ->fromHallOrManagedHalls($hall_id)
            ->screeningMovie($movie_id)
            ->search($search_query)
            ->withOmmitedTag('Dolby Atmos')
            ->sortOptional($do_sort, $sort_by, $sort_direction)
            ->paginateOptional($quantity);
    }

    /**
     * Returns an associative array of $quantity of screenings grouped by date for a movie
     * [Date => [Screening, Screening, ...]]
     */
    public function getScreeningsMapForMovie(Movie $movie, int $quantity): EloquentCollection
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
    Eager loads screening
    */
    public function eagerLoadScreening($screening): Screening
    {
        return Screening::with('movie')->with('hall')->where('id', $screening)->first();
    }

    /*
    * Used in App\Scheduling\AdvertScheduling
    */
    public function getScreeningsForAdvertScheduling(): EloquentCollection
    {
        return Screening::with('adverts')
            ->upcoming()
            ->withFreeAdSlots()
            ->orderBy('start_time')
            ->get();
    }

    /**
     * Cancels a screening, unscheduling adverts and notifying users is done by the ScreeningObserver by dispatching jobs
     */
    public function cancelScreening(int $screening_id): void
    {
        $screening = Screening::find($screening_id);
        $screening->delete();
    }

    /**
     * Implementation of CanExport interface
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        $bom = "\xEF\xBB\xBF";

        $headers = [
            $bom . 'ID Projekcije',
            'Naziv Sale',
            'Naslov Filma',
            'Vreme Prikazivanja',
            'Vreme Završetka',
            'Broj Reklama',
            'Broj Karata',
        ];
        $output = [];
        foreach ($data as $screening) {
            $output[] = [
                $screening['id'] ?? '',
                $screening['hall']['name'] ?? '',
                $screening['movie']['title'] ?? '',
                $screening['start_time'] ?? '',
                $screening['end_time'] ?? '',
                $screening['adverts_count'] ?? '',
                $screening['tickets_count'] ?? '',
            ];
        }
        array_unshift($output, $headers);
        return $output;
    }

    /**
     * Creates screenings for the selected dates and times
     * Calls BookingService massCancelOnIntersect() to cancel pending bookings that intersect with the newly created screenings
     * Returns an array of [amount_created, intersectedCount]
     */
    public function massCreateScreenings(Movie $movie, Hall $hall, Tag $tag, array $selected_dates, array $selected_times, BookingService $bookingService, RequestableService $requestableService): array
    {
        $screenings = collect();

        // Insert the screenings
        DB::transaction(function () use ($movie, $hall, $tag, $selected_dates, $selected_times, &$screenings) {
            foreach ($selected_dates as $date) {
                foreach ($selected_times as $time) {
                    $screening = Screening::create([
                        'hall_id' => $hall->id,
                        'movie_id' => $movie->id,
                        'start_time' => Carbon::parse($date . ' ' . $time),
                    ]);
                    $screening->tags()->attach(Tag::where('name', 'Dolby Atmos')->first()->id);
                    $screening->tags()->attach($tag->id);
                    $screenings->push($screening);
                }
            }
        });

        // Extract [start_time, end_time] pairs from the screenings
        $timeIntervals = $screenings->map(function ($screening) {
            return [$screening->start_time->format('H:i'), $screening->end_time->format('H:i')];
        })->unique()->toArray();

        // Cancel pending bookings that intersect with the newly created screenings
        $intersectedCount = $bookingService->massCancelOnIntersect($selected_dates, $timeIntervals, $hall->id, $requestableService);

        return [$screenings->count(), $intersectedCount];
    }
}
