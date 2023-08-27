<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Resources\HallService;
use App\Services\Resources\MovieService;
use App\Services\Resources\TagService;
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

}
