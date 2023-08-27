<?php

namespace App\Traits\Reporting;

use App\Enums\Period;

trait DataFormatter
{
    /**
     * @param Period $period
     * @return string
     */
    protected function getReportDataFormat(Period $period): string
    {
        return match ($period) {
            Period::WEEKLY => 'd/m',
            Period::MONTHLY => 'W',
            Period::YEARLY => 'M',
        };
    }
}
