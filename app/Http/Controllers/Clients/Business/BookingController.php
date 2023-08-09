<?php

namespace App\Http\Controllers\Clients\Business;

use App\Models\Hall;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Encryption\DecryptException;

class BookingController extends Controller
{

    /**
    * Show the form for creating a new resource.
    */
    public function create(Request $request, User $user, Hall $hall)
    {
        // Dates are encrypted as a quickfix to users manually changing URL to get any time they want.. TODO better safequard against this
        try{
        $date = Carbon::parse(decrypt($request->query('date')));
        $start_time = Carbon::parse(decrypt($request->query('start_time')));
        $end_time = Carbon::parse(decrypt($request->query('end_time')));
        $duration = $end_time->diffInHours($start_time);
        } catch(DecryptException $e){   //URL is manually changed
            throw new AuthorizationException(403);
        }

        return view('business.booking.create', [
            'hall' => $hall,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'duration' => $duration,
        ]);
    }


    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request, User $user, Hall $hall)
    {
        dd($request->all(), $user, $hall);
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
