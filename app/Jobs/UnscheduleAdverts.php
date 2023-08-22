<?php

namespace App\Jobs;

use App\Models\Screening;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnscheduleAdverts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Screening $screening)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->screening->adverts()->each(function ($advert) {
            $advert->quantity_remaining += 1;
            $advert->last_scheduled = now()->addYears(-4);
            $advert->save();
        });

        $this->screening->adverts()->detach();
    }
}
