<?php

namespace App\Observers;

use App\Models\Screening;

class ScreeningObserver
{
    /* Calculate the screening end time*/
    public function creating(Screening $screening)
    {
             $screening->end_time =
             $screening->start_time->addMinutes(config('advertising.duration') *
             config('advertising.per_screening') + $screening->movie->duration);
    }
}
