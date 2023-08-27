<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use App\Models\Booking;
use App\Traits\Reporting\DataFormatter;
use App\Traits\Reporting\FillerData;
use Carbon\Carbon;

class BookingService implements CanReport
{
    use FillerData, DataFormatter;

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
       $data = Booking::with('businessRequest')
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

        $filler_data = $this->buildFillerData(function ($period) {
            return 0;
        }, $period);

        return array_replace($filler_data, $data);
    }
}
