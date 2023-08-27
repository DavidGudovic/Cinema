<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use App\Models\Booking;
use App\Traits\Reporting\DataFormatter;
use App\Traits\Reporting\FillerDataAttributes;
use Carbon\Carbon;

class BookingService implements CanReport
{
    use FillerDataAttributes, DataFormatter;

    /**
     * Returns an array of accepted bookings for a hall/s grouped by date
     * [Date => count, Date => count, ...]
     *
     * @param Periods $period
     * @param int $hall_id
     * @return array
     */
    public function getReportableDataByPeriod(Periods $period, int $hall_id): array
    {
        return Booking::with('businessRequest')
            ->fromHallOrManagedHalls($hall_id)
            ->fromPeriod($period)
            ->status('accepted')
            ->get()
            ->groupBy(function ($booking) use ($period) {
                return $booking->start_time->format($this->getReportDataFormat($period));
            })
            ->map(function ($bookingsByStatus) {
                return $bookingsByStatus->count() ?? 0;
            })
            ->toArray();

    }

    /**
     * Builds an array with all possible periods as keys and 0 as values
     *
     * @param Periods|null $period
     * @return array
     */
    public function buildFillerData(?Periods $period = null): array
    {
        // TODO: Implement buildFillerData() method.
    }

}
