<?php

namespace App\Jobs;

use App\Scheduling\AdvertPriorityQueue;
use App\Services\AdvertService;
use App\Services\ScreeningService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleAdverts
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
        $queue = $advertPriorityQueue;
        $adverts_priority_map = $advertService->getAdvertSchedulingPriorityMap();  /* [Advert => priority] */
        $adverts_quantity_map = $advertService->getAdvertQuantityMap($adverts_priority_map->keys()); /* [Advert => quantity_left] */
        $screenings = $screeningService->getScreeningsForAdvertScheduling();
        $scheduled_adverts = [];    /* Adverts that have been scheduled, non-unique array */

        // Build the priority queue
        foreach ($adverts_priority_map as $advertID => $priority) {
            $queue->insert($advertID, $priority);
        }

        // Schedule adverts, update their last scheduled time (updated_at), and save them
        foreach ($screenings as $screening) {
            $queue_clone = clone $queue;
            while ($queue_clone->count() > 0 && $screening->adverts->count() < config('advertising.per_screening')) {
                $advertID = $queue_clone->extract();


                // Skip this advert if the screening already has it
                if ($screening->adverts->contains($advertID)) {
                    continue;
                }

                if($adverts_quantity_map[$advertID] == 0) {
                    continue;
                }

                $scheduled_adverts[] = $advertID;
                $adverts_quantity_map[$advertID] -= 1;
                $screening->adverts()->attach($advertID);
            }
        }
        $advertService->massUpdateAdverts($scheduled_adverts);
    }
}
