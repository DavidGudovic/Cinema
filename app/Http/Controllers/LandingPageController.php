<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\GenreService;

class LandingPageController extends Controller
{
    public function index(GenreService $genreService, TagService $tagService)
    {
        return view('index', [
            'movies' => Movie::showcased()->get(),
            'tags' => $tagService->getTags(),
            'genres' => $genreService->getGenres()
        ]);
    }
}
