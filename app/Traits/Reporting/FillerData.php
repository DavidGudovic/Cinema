<?php

namespace App\Traits\Reporting;

use App\Enums\Period;
use Carbon\Carbon;

trait FillerData
{
    /**
     * Builds an array with all possible periods and statuses as keys and 0 as values
     *
     * @param callable $customLogic
     * @param Period|null $period
     * @return array
     */
    public function buildFillerData(callable $customLogic, ?Period $period = null): array
    {
        $filler_data = [];

        list($start_date, $end_date, $incrementFunc, $format) =
            $this->getFillerAttributes(function ($period) {
                return $this->getReportDataFormat($period);
            }, $period);

        for ($date = $start_date; $date->lte($end_date); $incrementFunc($date)) {
            $formattedDate = $date->format($format);
            $filler_data[$formattedDate] = $customLogic($formattedDate);
        }

        return $filler_data;
    }

    /**
     * @param callable $dataFormatter
     * @param Period|null $period
     * @return array
     */
    protected function getFillerAttributes(callable $dataFormatter, ?Period $period = null): array
    {
        return [$start_date, $end_date, $incrementFunc, $format] = match ($period) {
            Period::WEEKLY => [
                Carbon::today()->subWeek(),
                Carbon::today(),
                fn($date) => $date->addDay(),
                $dataFormatter($period)
            ],
            Period::MONTHLY => [
                Carbon::today()->subMonth(),
                Carbon::today(),
                fn($date) => $date->addWeek(),
                $dataFormatter($period)
            ],
            Period::YEARLY => [
                Carbon::today()->subYear(),
                Carbon::today(),
                fn($date) => $date->addMonth(),
                $dataFormatter($period)
            ],
        };
    }
}
