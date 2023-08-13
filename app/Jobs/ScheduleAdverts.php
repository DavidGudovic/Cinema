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
        $adverts = $advertService->getAdvertSchedulingPriorityMap();
        $screenings = $screeningService->getScreeningsForAdvertScheduling();

        // Build the priority queue
        foreach ($adverts as $advertID => $priority) {
            $queue->insert($advertID, $priority);
        }

        // Schedule adverts, update their last scheduled time (updated_at), and save them
        foreach ($screenings as $screening) {
            while ($queue->count() > 0 && $screening->adverts()->count() < config('advertising.per_screening')) {
                $advertID = $queue->extract();
                $screening->adverts()->attach($advertID);
                $advertService->updateAdvert($advertID);
            }
        }
    }
}
