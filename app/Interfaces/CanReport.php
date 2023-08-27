<?php

namespace App\Interfaces;

use App\Enums\Periods;

interface CanReport
{
    public function getReportableDataByPeriod(Periods $period, int $hall_id): array;
    public function getReportDataFormat(Periods $period): string;
}
