<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreRequest;
use App\Models\Movie;
use App\Services\GenreService;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     */
    public function index()
    {
        return view('admin.movie.index');
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create(GenreService $genreService)
    {
        return view('admin.movie.create', [
            'genres' => $genreService->getGenres()
        ]);
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request, MovieService $movieService)
    {
        $movieService->createMovie($request);
        return redirect()->route('management.movies.index');
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit(Movie $movie, GenreService $genreService)
    {
        return view('admin.movie.edit', [
            'movie' => $movie,
            'genres' => $genreService->getGenres()
        ]);
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, int $id)
    {
        //
    }

}
