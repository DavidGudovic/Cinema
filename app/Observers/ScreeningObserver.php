<?php

namespace App\Observers;

use App\Jobs\ScheduleAdverts;
use App\Models\Screening;

class ScreeningObserver
{
    /* Calculate the screening end time and reevaluate advert schedule*/
    public function creating(Screening $screening)
    {
             $screening->end_time =
             $screening->start_time->addMinutes(config('advertising.duration') *
             config('advertising.per_screening') + $screening->movie->duration);

             dispatch(new ScheduleAdverts());
    }
}
