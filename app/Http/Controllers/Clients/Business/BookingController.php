<?php

namespace App\Http\Controllers\Clients\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateRequest;
use App\Models\Hall;
use App\Services\Resources\BookingService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
    * Show the form for creating a new resource.
    */
    public function create(Request $request, Hall $hall)
    {
        // Dates are encrypted as a quickfix to users manually changing URL to get any time they want.. TODO better safequard against this
        try{
            $date = Carbon::parse(decrypt($request->query('date')));
            $start_time = Carbon::parse(decrypt($request->query('start_time')));
            $end_time = Carbon::parse(decrypt($request->query('end_time')));
            $duration = $end_time->diffInHours($start_time);
        } catch(DecryptException $e){   //URL is tampered with
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
    public function store(CreateRequest $request, Hall $hall, BookingService $bookingService)
    {
        // Date repacking
        $start_time = Carbon::createFromFormat('Y-m-d H:i', substr($request->date , 0, -8) . ' ' . $request->start_time);
        $end_time = Carbon::createFromFormat('Y-m-d H:i', substr($request->date , 0, -8) . ' ' . $request->end_time);

        try {
            $bookingService->tryCreateBooking($hall->id, $request->text, $request->price, $start_time, $end_time);
        } catch (\Exception $e) {
        }
        return redirect()->route('halls.index')->with('success', 'Uspešno ste poslali zahtev za rezervaciju, Hvala na poverenju!');
    }

}
