<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use App\Models\Screening;
use Carbon\Carbon;

class TicketService implements CanReport
{
    /**
     * @param Periods $period
     * @param int $hall_id
     * @return array
     * [ [Date => [Otkazane => int, Ostvarene => int]], [Date => [Otkazane => int, Ostvarene => int]], ... ]
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
     * @param Periods|null $period
     * @return array
     */
    public function buildFillerData(?Periods $period = null): array
    {
        $filler_data = [];

        // Assigns the correct values to the variables based on the period
        [$start_date, $end_date, $incrementFunc, $format] = match ($period) {
            Periods::WEEKLY => [
                Carbon::today()->subWeek(),
                Carbon::today(),
                fn($date) => $date->addDay(),
                $this->getReportDataFormat($period)
            ],
            Periods::MONTHLY => [
                Carbon::today()->subMonth(),
                Carbon::today(),
                fn($date) => $date->addWeek(),
                $this->getReportDataFormat($period)
            ],
            Periods::YEARLY => [
                Carbon::today()->subYear(),
                Carbon::today(),
                fn($date) => $date->addMonth(),
                $this->getReportDataFormat($period)
            ],
        };

        for ($date = $start_date; $date->lte($end_date); $incrementFunc($date)) {
            $filler_data[$date->format($format)]['Otkazane'] = 0;
            $filler_data[$date->format($format)]['Ostvarene'] = 0;
        }

        return $filler_data;
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
