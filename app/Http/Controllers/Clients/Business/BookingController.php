<?php

namespace App\Http\Controllers\Clients\Business;

use App\Models\Hall;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class BookingController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user, Booking $booking, Hall $hall, Carbon $date)
    {
         return view('business.booking.create',['hall' => $hall, 'date' => $date]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user, Hall $hall)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
