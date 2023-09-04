<?php

namespace App\Traits\Reporting;

use App\Enums\Period;
use Carbon\Carbon;

trait PeriodSorter
{
    protected function sortPeriod(Period $period, array $data): array
    {
        return match ($period) {
            Period::WEEKLY, Period::MONTHLY => $this->sort($data),
            Period::YEARLY => $this->sortYearly($data),
        };
    }

    private function sort(array $data): array
    {
        ksort($data);
        return $data;
    }

    private function sortYearly(array $data): array
    {
        uksort($data, function ($a, $b) {
            $monthA = Carbon::parse($a)->month;
            $monthB = Carbon::parse($b)->month;
            return $monthA <=> $monthB;
        });

        return $data;
    }
}
