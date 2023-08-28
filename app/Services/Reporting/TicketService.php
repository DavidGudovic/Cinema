<?php

namespace App\Services\Reporting;

use App\Enums\Period;
use App\Interfaces\CanReport;
use App\Models\Screening;
use App\Traits\Reporting\PeriodFormatter;
use App\Traits\Reporting\FillerData;

class TicketService implements CanReport
{
    use FillerData, PeriodFormatter;

    /**
     * Returns an array of tickets count grouped by date and by status
     * [ [Date => [Otkazane => int, Ostvarene => int]], [Date => [Otkazane => int, Ostvarene => int]], ... ]
     *
     * @param Period $period
     * @param int $hall_id
     * @return array
     */
    public function getReportableDataByPeriod(Period $period, int $hall_id): array
    {
        $data = Screening::with('tickets')
            ->fromPeriod($period)
            ->fromHall($hall_id)
            ->get()
            ->groupBy(function ($screening) use ($period) {
                return $screening->start_time->format($this->getReportDataFormat($period));
            })
            ->map(function ($screenings) {
                return [
                    'Otkazane' => $screenings->flatMap->tickets->where('seat_count', '=', 0)->count(),
                    'Ostvarene' => $screenings->flatMap->tickets->where('seat_count', '>', 0)->count(),
                ];
            })
            ->sortKeys()
            ->toArray();

        $filler_data = $this->buildFillerData(function () {
            return [
                'Otkazane' => 0,
                'Ostvarene' => 0,
            ];
        }, $period);

        return array_replace($filler_data, $data);
    }
}
