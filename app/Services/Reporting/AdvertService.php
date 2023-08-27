<?php

namespace App\Services\Reporting;

use App\Enums\Period;
use App\Interfaces\CanReport;
use App\Models\Screening;
use App\Traits\Reporting\DataFormatter;
use App\Traits\Reporting\FillerData;

class AdvertService implements CanReport
{
    use FillerData, DataFormatter;

    /**
     * Returns an array of adverts screenings count grouped by date
     * [Date => count, Date => count, ...]
     *
     * @param Period $period
     * @param int $hall_id
     * @return array
     */
    public function getReportableDataByPeriod(Period $period, int $hall_id): array
    {
        $data = Screening::withCount('adverts')
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

        $filler_data = $this->buildFillerData(function ($period) {
            return 0;
        }, $period);

        return array_replace($filler_data, $data);
    }
}
