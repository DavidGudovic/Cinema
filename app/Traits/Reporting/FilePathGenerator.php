<?php

namespace App\Traits\Reporting;

use App\Enums\Period;
use Illuminate\Support\Carbon;

trait FilePathGenerator
{
    public function getReportFilePath(Period $period, int $hall, Carbon $date_from): string
    {
        return 'reports/' . $period->value . '/' . $date_from->format('Y-m-d') . '-' . $hall . '.pdf';
    }
}
