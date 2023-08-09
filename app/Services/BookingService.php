<?php
namespace App\Services;

use App\Models\Hall;
use App\Models\User;
use App\Models\Booking;
use App\Models\BusinessRequest;
use Illuminate\Support\Facades\DB;

class BookingService {

    /*
    * Create a new booking as well as a new business request, associate the two and return the booking
    */
    public function tryCreateBooking($user, $hall, $text, $price, $start_time, $end_time) : Booking
    {
        try {
            DB::beginTransaction();  // Make the insert atomic

            $businessRequest = BusinessRequest::make([
                'price' => $price,
                'user_id' => $user,
                'text' => $text,
            ]);
            $booking = Booking::create([
                'hall_id' => $hall,
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);

            $businessRequest->requestable()->associate($booking);
            $businessRequest->save();

            $booking->business_request_id = $businessRequest->id;
            $booking->save();

            DB::commit();  // Commit the insert

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $booking;
    }

}
