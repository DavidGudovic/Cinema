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
    Eager loads screening
    */
    public function eagerLoadScreening($screening)
    {
        return Screening::with('movie')->with('hall')->where('id', $screening)->first();
    }
}
