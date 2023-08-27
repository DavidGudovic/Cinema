<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use App\Models\Screening;

class AdvertService implements CanReport
{
    /**
     * @param Periods $period
     * @param int $hall_id
     * @return array
     */
    public function getReportableDataByPeriod(Periods $period, int $hall_id): array
    {
        return Screening::withCount('adverts')
            ->fromPeriod($period)
            ->fromHallOrManagedHalls($hall_id)->get()
            ->groupBy(function ($screening) use ($period) {
                return $screening->start_time->format($this->getReportDataFormat($period));
            })
            ->map(function ($screenings) {
                return $screenings->sum('adverts_count');
            })
            ->sortKeys()
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
