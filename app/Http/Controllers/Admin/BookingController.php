<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('admin.booking.index');
    }

    public function edit(Booking $booking)
    {
    }

    public function update(Request $request, Booking $booking)
    {
    }
}
