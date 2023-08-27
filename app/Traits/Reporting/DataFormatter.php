<?php

namespace App\Traits\Reporting;

use App\Enums\Periods;

trait DataFormatter
{
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
