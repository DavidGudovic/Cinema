<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use App\Models\Screening;
use App\Traits\Reporting\DataFormatter;
use App\Traits\Reporting\FillerDataAttributes;

class AdvertService implements CanReport
{
    use FillerDataAttributes, DataFormatter;
    /**
     * Returns an array of adverts screenings count grouped by date
     * [Date => count, Date => count, ...]
     *
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

    /**
     * Builds an array with all possible periods as keys and 0 as values
     *
     * @param Periods|null $period
     * @return array
     */
    public function buildFillerData(?Periods $period = null): array
    {

    }

}
