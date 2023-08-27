<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use App\Models\Screening;
use App\Traits\Reporting\DataFormatter;
use App\Traits\Reporting\FillerDataAttributes;

class TicketService implements CanReport
{
    use FillerDataAttributes, DataFormatter;

    /**
     * Returns an array of tickets count grouped by date and by status
     * [ [Date => [Otkazane => int, Ostvarene => int]], [Date => [Otkazane => int, Ostvarene => int]], ... ]
     *
     * @param Periods $period
     * @param int $hall_id
     * @return array
     */
    public function getReportableDataByPeriod(Periods $period, int $hall_id): array
    {
        $data = Screening::with('tickets')
            ->fromPeriod($period)
            ->fromHallOrManagedHalls($hall_id)
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

        return array_replace($this->buildFillerData($period), $data);
    }

    /**
     * Builds an array with all possible periods and statuses as keys and 0 as values
     *
     * @param Periods|null $period
     * @return array
     */
    public function buildFillerData(?Periods $period = null): array
    {
        $filler_data = [];

        list($start_date, $end_date, $incrementFunc, $format) =
            $this->getFillerAttributes(function ($period) {
                return $this->getReportDataFormat($period);
            }, $period);

        for ($date = $start_date; $date->lte($end_date); $incrementFunc($date)) {
            $filler_data[$date->format($format)]['Otkazane'] = 0;
            $filler_data[$date->format($format)]['Ostvarene'] = 0;
        }

        return $filler_data;
    }
}
