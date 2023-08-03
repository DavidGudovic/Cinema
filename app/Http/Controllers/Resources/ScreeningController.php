<?php

namespace App\Http\Controllers\Resources;

use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\Request;
use App\Services\ScreeningService;
use App\Http\Controllers\Controller;

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
        setlocale(LC_TIME, 'sr_Latn_RS.UTF-8');
        return view('resources.screenings.index', [
            'movie' => $movie,
            'screenings_map' => $screeningService->getScreeningsMapForMovie($movie, 5),
        ]);
    }

    /**
     * Display a screening
     */
    public function show(Screening $screening)
    {
        //
    }
}
