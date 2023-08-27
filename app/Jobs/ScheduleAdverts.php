<?php

namespace App\Jobs;

use App\Scheduling\AdvertPriorityQueue;
use App\Services\Resources\AdvertService;
use App\Services\Resources\ScreeningService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleAdverts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {

    }
    /**
    * Executes the job to schedule adverts
    */
    public function handle(AdvertService $advertService, ScreeningService $screeningService, AdvertPriorityQueue $advertPriorityQueue): void
    {
        $adverts_priority_map = $advertService->getAdvertSchedulingPriorityMap();  /* [Advert => priority] */
        $adverts_quantity_map = $advertService->getAdvertQuantityMap($adverts_priority_map->keys()); /* [Advert => quantity_left] */
        $screenings = $screeningService->getScreeningsForAdvertScheduling();
        $scheduled_adverts = [];    /* Adverts that have been scheduled, non-unique array */

        // Build the priority queue
        foreach ($adverts_priority_map as $advertID => $priority) {
            $advertPriorityQueue->insert($advertID, $priority);
        }

        // Schedule adverts, update their last scheduled time (updated_at), and save them
        foreach ($screenings as $screening) {
            $queue_clone = clone $advertPriorityQueue;
            $advert_count = $screening->adverts->count();

            while ($queue_clone->count() > 0 && $advert_count < config('settings.advertising.per_screening')) {
                $advertID = $queue_clone->extract();
                if ($screening->adverts->contains($advertID) || $adverts_quantity_map[$advertID] == 0) continue;

                $scheduled_adverts[] = $advertID;
                $adverts_quantity_map[$advertID] -= 1;
                $advert_count++;
                $screening->adverts()->attach($advertID);
            }
        }

        // Update the adverts that have been scheduled, atomic update
        $advertService->massUpdateAdverts($scheduled_adverts);
    }
}
