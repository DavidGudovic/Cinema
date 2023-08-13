<?php

namespace App\Observers;

use App\Enums\Status;
use App\Jobs\ScheduleAdverts;
use App\Models\Advert;
use App\Models\Booking;
use App\Models\BusinessRequest;

class BusinessRequestObserver
{
    public function deleted(BusinessRequest $request)
    {
        $request->status = Status::CANCELLED;
        $request->save();
        $request->requestable()->delete();
    }

    public function saved(BusinessRequest $request)
    {

        if($request->requestable instanceof Advert && $request->isDirty('status') && $request->status == 'ACCEPTED'){
            dispatch(new ScheduleAdverts());
        }
    }
}
