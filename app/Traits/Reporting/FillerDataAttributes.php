<?php

namespace App\Traits\Reporting;

use App\Enums\Periods;
use Carbon\Carbon;

trait FillerDataAttributes
{
    /**
     * @param callable $dataFormatter
     * @param Periods|null $period
     * @return array
     */
    public function getFillerAttributes(callable $dataFormatter, ?Periods $period = null): array
    {
        return [$start_date, $end_date, $incrementFunc, $format] = match ($period) {
            Periods::WEEKLY => [
                Carbon::today()->subWeek(),
                Carbon::today(),
                fn($date) => $date->addDay(),
                $dataFormatter($period)
            ],
            Periods::MONTHLY => [
                Carbon::today()->subMonth(),
                Carbon::today(),
                fn($date) => $date->addWeek(),
                $dataFormatter($period)
            ],
            Periods::YEARLY => [
                Carbon::today()->subYear(),
                Carbon::today(),
                fn($date) => $date->addMonth(),
                $dataFormatter($period)
            ],
        };
    }
}
