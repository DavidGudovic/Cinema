<?php

namespace App\Observers;

use App\Enums\Status;
use App\Jobs\ScheduleAdverts;
use App\Models\Advert;
use App\Models\Booking;
use App\Models\BusinessRequest;

class BusinessRequestObserver
{
    /* Change status of cancelled (soft deleted) requests and cascade soft delete*/
    public function deleted(BusinessRequest $request)
    {
        $request->status = Status::CANCELLED;
        $request->save();
        $request->requestable()->delete();
    }

    public function saved(BusinessRequest $request)
    {

        /* If its a newly accepted advert, run the scheduler*/
        if($request->requestable instanceof Advert && $request->isDirty('status') && $request->status == 'ACCEPTED'){
            dispatch(new ScheduleAdverts());
        }
    }
}