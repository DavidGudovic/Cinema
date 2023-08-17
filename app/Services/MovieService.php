<?php
namespace App\Services;

use App\Models\Movie;
use Nette\NotImplementedException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MovieService
{
    public function getMovies() : EloquentCollection
    {
        return Movie::all();
    }
    /**
    * Get all movies that have upcoming screenings now, tommorow or in the next week, filtered by genre when genre != NULL.
    */
    public function getMoviesByGenreScreeningTimes(?array $genres = NULL, ?string $screening_time = 'any') : EloquentCollection
    {
        return Movie::with('genre')
        ->hasScreenings()
        ->fromGenres($genres)
        ->screeningTime($screening_time)
        ->get();
    }

    /*
    * Get all movies by title/director/genre query
    */
    public function getBySearch(string $search_query) : EloquentCollection
    {
        return Movie::search($search_query)->hasScreenings()->get();
    }

    /*
    * Get destict tag image urls for each movie that has screenings [MovieID => [tag1, tag2, ...]]
    */
    public function getDestinctTagUrls() : array
    {
        return Movie::with('screenings.tags')
        ->hasScreenings()
        ->get()
        ->mapWithKeys(function ($movie) {
            return [
                $movie->id => $movie->screenings
                ->pluck('tags.*.image_url')
                ->flatten()
                ->unique()
            ];
        })->toArray();
    }


    /*
    * Returns assoc array of next screening times for all movies with screenings  [MovieID => Next_Screening_Time]
    */
    public function getNextScreenings() : array
    {
        return Movie::with('screenings')
        ->hasScreenings()
        ->get()
        ->mapWithKeys(function ($movie) {
            return [$movie->id =>
            $movie->screenings
            ->where('start_time', '>=', now())
            ->sortBy('start_time')
            ->first()
            ->start_time
            ->format('d/m H:i')
        ];})
        ->toArray();
    }

    /*
    * Eager load all relevant direct/nested relationships for a movie
    */
    public function eagerLoadMovie(int $id) : Movie
    {
        return Movie::with('genre', 'screenings.tags')
        ->findOrFail($id);
    }
}
