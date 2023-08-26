<?php

namespace App\Observers;

use App\Jobs\ScheduleAdverts;
use App\Jobs\UnscheduleAdverts;
use App\Mail\ScreeningCancelled;
use App\Models\Screening;
use Illuminate\Support\Facades\Mail;

class ScreeningObserver
{
    /* Calculate the screening end time and reevaluate advert schedule*/
    public function creating(Screening $screening)
    {
             $screening->end_time =
             $screening->start_time->addMinutes(config('settings.advertising.duration') *
             config('settings.advertising.per_screening') + $screening->movie->duration);

             dispatch(new ScheduleAdverts());
    }

    public function updating(Screening $screening)
    {
        $screening->end_time =
        $screening->start_time->addMinutes(config('settings.advertising.duration') *
        config('settings.advertising.per_screening') + $screening->movie->duration);
    }

    public function deleted(Screening $screening)
    {
        $user_emails = collect();

        // Collect all user emails and delete tickets
        $screening->tickets->each(function ($ticket) use (&$user_emails) {
            $user_emails->push($ticket->user->email);
            $ticket->delete();
        });

        // Send email to all users who bought tickets
        ($user_emails->unique())->each(function ($email) use ($screening) {
            Mail::to($email)->send(new ScreeningCancelled($screening));
        });

        // Unschedule adverts
        dispatch(new UnscheduleAdverts($screening));
    }
}
