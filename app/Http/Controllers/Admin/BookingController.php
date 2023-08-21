<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Requestable\UpdateRequest;
use App\Models\Booking;
use App\Services\HallService;
use App\Services\RequestableService;
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
        return view('admin.booking.edit', [
            'booking' => $booking,
            'action' => $request['action'] ?? 'ACCEPT',
        ]);
    }

    public function update(Booking $booking, UpdateRequest $request, RequestableService $requestableService)
    {
        $requestableService->changeRequestStatus(
            $booking->businessRequest,
            $request['action'] == 'ACCEPT' ? Status::ACCEPTED : Status::REJECTED,
            $request['response'],
        );
        return redirect()->route('bookings.index');
    }
}
