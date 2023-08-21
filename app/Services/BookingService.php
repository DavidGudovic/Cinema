<?php
namespace App\Services;

use App\Interfaces\CanExport;
use App\Models\Hall;
use App\Models\User;
use App\Models\Booking;
use App\Models\BusinessRequest;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookingService implements CanExport {

    /**
     * Returns a paginated, filtered list of bookings or a searched through list of bookings
     * All parameters are optional, if none are set, all bookings are returned, paginated by $quantity, default 10
     */
    public function getFilteredBookingsPaginated(): LengthAwarePaginator|Collection
    {
        return Booking::with('businessRequest')->with('hall')
            ->paginate(10);
    }
    /**
    * Create a new booking as well as a new business request, associate the two and return the booking
    */
    public function tryCreateBooking($hall, $text, $price, $start_time, $end_time) : Booking
    {
        try {
            DB::beginTransaction();  // Make the insert atomic

            $businessRequest = BusinessRequest::make([
                'price' => $price,
                'user_id' => auth()->user()->id,
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

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $booking;
    }
    /**
     * Implementation of the CanExport interface
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        // TODO: Implement sanitizeForExport() method.
    }
}
