<?php

namespace App\Services;

use App\Interfaces\CanExport;
use App\Models\Booking;
use App\Models\BusinessRequest;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookingService implements CanExport
{

    /**
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
     * Create a new booking as well as a new business request, associate the two and return the booking
     */
    public function tryCreateBooking($hall, $text, $price, $start_time, $end_time): Booking
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
}
