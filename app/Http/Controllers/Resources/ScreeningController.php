<?php

namespace App\Http\Controllers\Resources;

use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
* Resource controller for App\Models\Screening
*/

class ScreeningController extends Controller
{
    /**
     * Display a listing of Screenings
     */
    public function index(Movie $movie)
    {
        return view('resources.screenings.index', [
            'movie' => $movie,
            'screenings' => Screening::all(),
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
