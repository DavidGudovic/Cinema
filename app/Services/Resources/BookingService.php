<?php

namespace App\Services\Resources;

use App\Enums\Status;
use App\Interfaces\CanExport;
use App\Models\Booking;
use App\Models\BusinessRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookingService implements CanExport
{
    /**
     * @param RequestableService $requestableService
     * @param string $status
     * @param string $search_query
     * @param bool $do_sort
     * @param string $sort_by
     * @param string $sort_direction
     * @param array $halls
     * @param int $user_id
     * @param int $quantity
     * @return LengthAwarePaginator|Collection
     * Returns a paginated, filtered list of bookings or a searched through list of bookings
     * All parameters are optional, if none are set, all bookings are returned, paginated by $quantity, default 10
     */
    public function getFilteredBookingsPaginated(RequestableService $requestableService, string $status = 'all', string $search_query = '', bool $do_sort = false, string $sort_by = 'title', string $sort_direction = 'ASC', array $halls = [], int $user_id = 0, int $quantity = 0): LengthAwarePaginator|Collection
    {
        $sortParams = $requestableService->resolveSortByParameter($sort_by);

        return Booking::with('businessRequest')->with('hall')
            ->fromHalls($halls)
            ->user($user_id)
            ->status($status)
            ->search($search_query)
            ->sortPolymorphic($do_sort, $sortParams['type'], $sortParams['relation'], $sortParams['column'], $sort_direction)
            ->paginateOptionally($quantity);
    }

    /**
     * @param int $hall_id
     * @param string $text
     * @param int $price
     * @param string $start_time
     * @param string $end_time
     * @return Booking
     * Create a new booking as well as a new business request, associate the two and return the booking
     * @throws Exception
     */
    public function tryCreateBooking(int $hall_id, string $text, int $price, string $start_time, string $end_time): Booking
    {
        try {
            DB::beginTransaction();  // Make the insert atomic

            $businessRequest = BusinessRequest::make([
                'price' => $price,
                'user_id' => auth()->user()->id,
                'text' => $text,
            ]);
            $booking = Booking::create([
                'hall_id' => $hall_id,
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
     * @param array|Collection $data
     * @return array
     *  Implementation of the CanExport interface
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        $bom = "\xEF\xBB\xBF";

        $headers = [
            $bom . 'Vreme Početka',
            'Vreme Završetka',
            'ID Sale',
            'Ime Sale',
            'Status',
            'Cena',
            'ID Korisnika',
            'ID Poslovnog Zahteva'
        ];
        $output = [];
        foreach ($data as $booking) {
            $output[] = [
                $booking['start_time'],
                $booking['end_time'],
                $booking['hall_id'] ?? '',
                $booking['hall']['name'] ?? '',
                $booking['business_request']['status'] ?? '',
                $booking['business_request']['price'] ?? '',
                $booking['business_request']['user_id'] ?? '',
                $booking['business_request_id'] ?? ''
            ];
        }

        array_unshift($output, $headers);
        return $output;
    }

    /**
     * @param array $dates
     * @param array $times
     * @param int $hall_id
     * @param RequestableService $requestableService
     * @return int
     *  Cancel all bookings that intersect with the given dates and times
     *  Returns the number of cancelled bookings
     */
    public function massCancelOnIntersect(array $dates, array $times, int $hall_id, RequestableService $requestableService): int
    {
        // get the pending booking on the given $dates
        $bookings = Booking::with('businessRequest')
            ->fromHall($hall_id)
            ->status('pending')
            ->fromDates($dates)
            ->get();

        // filter out only the intersecting ones
        $bookings = $bookings->filter(function ($booking) use ($times) {
            foreach ($times as $time) {
                [$start_time, $end_time] = $time;
                $start_time_carbon = Carbon::createFromFormat('H:i', $start_time);
                $end_time_carbon = Carbon::createFromFormat('H:i', $end_time);

                $booking_start_time = Carbon::createFromFormat('H:i', $booking->start_time->format('H:i'));
                $booking_end_time = Carbon::createFromFormat('H:i', $booking->end_time->format('H:i'));

                if ($booking_start_time->lte($end_time_carbon) && $booking_end_time->gt($start_time_carbon)) {
                    return true;
                }

            }
            return false; // No intersect found, filter out the booking
        });
        // cancel them
        foreach ($bookings as $booking) {
            $requestableService->changeRequestStatus($booking->businessRequest, Status::REJECTED, config('messages.request_cancelled_intersect'));
            $requestableService->cancelRequest($booking->businessRequest);
        }

        return $bookings->count();
    }

}
