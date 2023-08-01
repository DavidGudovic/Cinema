<?php
namespace App\Services;

use App\Models\Movie;
use Nette\NotImplementedException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MovieService
{
    /**
    * Get all movies that have upcoming screenings, filtered by genre when genre != NULL.
    */

    public function getScreeningMoviesByGenres(array $genres = NULL) : EloquentCollection
    {
        return Movie::with('genre')->when($genres, function ($query, $genres) {
            return $query->whereHas('genre', function ($query) use ($genres) {
                $query->whereIn('id', $genres);
            });
        })->get();
    }

    /*
    * Get all movies by title/director/genre query
    */
    public function getBySearch(string $search_query){
        return Movie::search($search_query)->get();
    }
}
