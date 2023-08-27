<?php

namespace App\Interfaces;

use App\Enums\Period;

interface CanReport
{
    public function getReportableDataByPeriod(Period $period, int $hall_id): array;
}
