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
    public function index(MovieService $movieService, GenreService $genreService, ?int $genre = null)
    {
        return view('resources.movies.index', [
            'movies' => $movieService->getScreeningMoviesByGenres($genre ? [$genre] : null),
            'filters' => $genreService->getFiltersForGenres($genre),
        ]);
    }
}
