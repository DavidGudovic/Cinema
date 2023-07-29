<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\GenreService;

class LandingPageController extends Controller
{
    public function index(GenreService $genreService, TagService $tagService)
    {
        return view('index', ['tags' => $tagService->getTags(),
                              'fictionGenres' => $genreService->getFictionGenres(),
                              'nonFictionGenres' => $genreService->getNonFictionGenres()]);
    }
}
