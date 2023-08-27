<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use App\Models\Booking;

class BookingService implements CanReport
{
    /**
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

    public function buildFillerData(?Periods $period = null): array
    {
        // TODO: Implement buildFillerData() method.
    }

    /**
     * @param Periods $period
     * @return string
     */
    public function getReportDataFormat(Periods $period): string
    {
        return match ($period) {
            Periods::WEEKLY => 'd/m',
            Periods::MONTHLY => 'W',
            Periods::YEARLY => 'M',
        };
    }
}
