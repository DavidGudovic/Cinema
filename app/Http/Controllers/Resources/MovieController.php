<?php

namespace App\Http\Controllers\Resources;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Services\MovieService;
use App\Http\Controllers\Controller;
use App\Services\GenreService;

/*
* Resource controller for App\Models\Movie
*/
class MovieController extends Controller
{
    /**
     * Display a listing of Movies
     */
    public function index(Request $request, MovieService $movieService, GenreService $genreService)
    {
        return view('resources.movies.index', [
            'movies' => $movieService->getFilteredMoviesPaginated($request['genre'] ? [$request['genre']] : null),
            'filters' => $genreService->getFiltersForGenres($request['genre']),
        ]);
    }

    public function show(int $movie, MovieService $movieService)
    {
        return view('resources.movies.show', [
            'movie' => $movieService->eagerLoadMovie($movie),
        ]);
    }
}
