<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HallService;
use App\Services\MovieService;
use App\Services\TagService;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MovieService $movieService, HallService $hallService)
    {
        return view('admin.screening.index', [
            'movies' => $movieService->getFilteredMoviesPaginated(screening_time: 'with past'),
            'halls' => $hallService->getHalls(auth()->user()->id),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, MovieService $movieService, TagService $tagService)
    {
        return view('admin.screening.create', [
            'movie' => $movieService->getMovie($request['movie']),
            'halls' => auth()->user()->halls,
            'tags' => $tagService->getTags(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
