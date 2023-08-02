<?php
namespace App\Services;

use App\Models\Movie;
use Nette\NotImplementedException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MovieService
{
    /**
    * Get all movies that have upcoming screenings now, tommorow or in the next week, filtered by genre when genre != NULL.
    */
    public function getMoviesByGenreScreeningTimes(array $genres = NULL, string $screening_time = 'any') : EloquentCollection
    {
        return Movie::with('genre')->hasScreenings()->fromGenres($genres)->screeningTime($screening_time)->get();
    }

    /*
    * Get all movies by title/director/genre query
    */
    public function getBySearch(string $search_query){
        return Movie::search($search_query)->get();
    }
}
