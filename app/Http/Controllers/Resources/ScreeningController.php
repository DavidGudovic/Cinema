<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Screening;
use App\Services\Resources\ScreeningService;

/*
* Resource controller for App\Models\Screening
*/

class ScreeningController extends Controller
{
    /**
     * Display a listing of Screenings
     */
    public function index(Movie $movie, ScreeningService $screeningService)
    {
        if(app()->environment('production')) setlocale(LC_TIME, 'sr_RS@latin'); else  setlocale(LC_TIME, 'sr_Latn_RS.UTF-8');

        return view('resources.screenings.index', [
            'movie' => $movie,
            'screenings_map' => $screeningService->getScreeningsMapForMovie($movie, 5),
        ]);
    }

    /**
     * Display a screening
     */
    public function show(Movie $movie, Screening $screening)
    {
        return view('resources.screenings.show', [
            'movie' => $movie,
            'screening' => $screening,
        ]);
    }
}
