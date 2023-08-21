<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\HallService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(HallService $hallService)
    {
        return view('admin.booking.index', [
            'halls' => $hallService->getHalls(auth()->user()->id),
        ]);
    }

    public function edit(Request $request, Booking $booking)
    {

    }

    public function update(Request $request, Booking $booking)
    {
    }
}
