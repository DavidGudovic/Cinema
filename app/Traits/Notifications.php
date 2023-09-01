<?php

namespace App\Traits;

use App\Enums\Status;
use App\Interfaces\HasOwner;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait Notifications
{
    /**
     * Notifies the owner of a request with an email
     */
    public function notifyOwner(HasOwner $possession, Status $status, Mailable $accept_email, Mailable $reject_email): void
    {
        if (!empty($possession->user()->email)) {
            Mail::to($possession->user()->email)->send(
                $status == Status::ACCEPTED
                    ? $accept_email
                    : $reject_email
            );
        }
    }
}
