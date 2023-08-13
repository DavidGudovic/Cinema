<?php
namespace App\Services;

use App\Models\User;
use App\Models\Advert;
use App\Models\BusinessRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class AdvertService {
    /*
    * Returns an associative map of views per day for $quantity days in the past
    * A view is each seat associated to a ticket associated to a screening associated to an advert x amount of adverts shown at screening (should be 1 in most cases)
    * [Date => Views]
    */
    public function getViewsByWeekMap(Advert $advert, ?int $quantity = 10) : Collection
    {
        return $advert->screenings()->pastForDays($quantity)
        ->with('tickets')
        ->get()
        ->groupBy(function ($screening) {
            return $screening->start_time->format('d/m/Y'); // Group by start time
        })
        ->map(function ($screeningsByDate) {
            return $screeningsByDate->flatMap(function ($screening) {
                return $screening->tickets; // Get all tickets for each screening
            })
            ->sum(function ($ticket) {
                return $ticket->seat_count; // Sum the seat_count for the tickets
            });
        });
    }



    /*
    * Returns the amount of scheduled screenings for the advert
    */
    public function getScheduledCount($advert) : int
    {
        return Advert::where('id', $advert->id)
        ->withCount(['screenings' => function ($query) {
            $query->where('start_time', '>', now());
        }])
        ->first()
        ->screenings_count;
    }


    /*
    * Create a new advert as well as a new business request, associate the two and return the advert
    */
    public function tryCreateAdvert($text, $quantity, $title, $company, $advert_url) : Advert
    {
        try {
            DB::beginTransaction();  // Make the insert atomic

            $businessRequest = BusinessRequest::make([
                'price' => $quantity * config('advertising.price'),
                'user_id' => auth()->user()->id,
                'text' => $text,
            ]);

            $advert = Advert::create([
                'quantity' => $quantity,
                'title' => $title,
                'company' => $company,
                'advert_url' => $advert_url,
            ]);

            $businessRequest->requestable()->associate($advert);
            $businessRequest->save();

            $advert->business_request_id = $businessRequest->id;
            $advert->save();

            DB::commit();  // Commit the insert

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $advert;
    }

    /*
    * Gets quantity remaining map for passed advert ids
    */
    public function getAdvertQuantityMap($advertIDs) : Collection
    {
        return Advert::whereIn('id', $advertIDs)
        ->get()
        ->mapWithKeys(function ($advert) {
            return [$advert->id => $advert->quantity_remaining];
        });
    }
    /*
    * Get all accepted adverts that have quantity_remaining with their respective priorities
    * [Advert => Priority]
    */
    public function getAdvertSchedulingPriorityMap() : Collection
    {
        $adverts = Advert::status('ACCEPTED')->hasRemaining()->get();

        return $adverts->mapWithKeys(function ($advert) {
            return [$advert->id => $this->calculatePriority($advert)];
        });
    }

    /* Calculates an adverts priority based on quantity remaining and when it is last seen, modified by weights from config */
    private function calculatePriority(Advert $advert) : int
    {
        return $advert->quantity_remaining * config('advertising.weight_remaining') + Carbon::parse($advert->last_scheduled)->diffInDays(now()) * config('advertising.weight_last_scheduled');
    }

    /* Change the quantity_remaining */
    public function massUpdateAdverts($advertIDs)
    {
        $quantities = array_count_values($advertIDs);

        DB::transaction(function () use ($quantities) { // Make the update atomic
            foreach ($quantities as $advertID => $quantity) {
                Advert::where('id', $advertID)->decrement('quantity_remaining', $quantity);
                Advert::where('id', $advertID)->update([
                    'last_scheduled' => now()
                ]);
            }
        });
    }
}
