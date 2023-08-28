<?php

namespace App\Traits\Reporting;

use App\Enums\Period;

trait PeriodFormatter
{
    /**
     * @param Period $period
     * @return string
     */
    protected function getReportDataFormat(Period $period): string
    {
        return match ($period) {
            Period::WEEKLY => 'd/m',
            Period::MONTHLY => 'd',
            Period::YEARLY => 'M',
        };
    }
}
