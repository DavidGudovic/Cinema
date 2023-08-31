<?php

namespace App\Services\Resources;

use App\Interfaces\CanExport;
use App\Models\Advert;
use App\Models\BusinessRequest;
use App\Traits\WithRelationalSort;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvertService implements CanExport
{
    use WithRelationalSort;

    /**
     * Returns a paginated, filtered list of adverts or a searched through list of adverts
     * All parameters are optional, if none are set, all adverts are returned, paginated by $quantity, default 10
     *
     * @param string $status
     * @param int $user_id
     * @param string $quantity_left
     * @param string $search_query
     * @param bool $do_sort
     * @param string $sort_by
     * @param string $sort_direction
     * @param int $quantity
     * @return LengthAwarePaginator|Collection
     */
    public function getFilteredAdvertsPaginated(string $status = 'all', int $user_id = 0, string $quantity_left = 'any', string $search_query = '', bool $do_sort = false, string $sort_by = 'title', string $sort_direction = 'ASC', int $quantity = 10): LengthAwarePaginator|EloquentCollection
    {
        $sortParams = $this->resolveSortByParameter($sort_by);

        return Advert::with('businessRequest')
            ->byUser($user_id)
            ->status($status)
            ->quantityRemaining($quantity_left)
            ->search($search_query)
            ->sortPolymorphic($do_sort, $sortParams['type'], $sortParams['relation'], $sortParams['column'], $sort_direction)
            ->paginateOptionally($quantity);
    }

    /**
     * Returns an associative map of views per day for $quantity days in the past
     * A view is each seat associated to a ticket associated to a screening associated to an advert x amount of adverts shown at screening (should be 1 in most cases)
     * [Date => Views]
     *
     * @param Advert $advert
     * @param int|null $quantity
     * @return array
     */
    public function getViewsByWeekMap(Advert $advert, ?int $quantity = 5): array
    {
        return $advert->screenings()->with('tickets')->pastForDays($quantity)
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
            })->toArray();
    }

    /**
     * Returns the amount of scheduled screenings for the advert
     *
     * @param $advert
     * @return int
     */
    public function getScheduledCount($advert): int
    {
        return Advert::where('id', $advert->id)
            ->withCount(['screenings' => function ($query) {
                $query->where('start_time', '>', now());
            }])
            ->first()
            ->screenings_count;
    }

    /**
     * Create a new advert as well as a new business request, associate the two and return the advert
     *
     * @param $text
     * @param $quantity
     * @param $title
     * @param $company
     * @param $advert_url
     * @return Advert
     * @throws Exception
     */
    public function tryCreateAdvert($text, $quantity, $title, $company, $advert_url): Advert
    {
        try {
            DB::beginTransaction();  // Make the insert atomic

            $businessRequest = BusinessRequest::make([
                'price' => $quantity * config('settings.advertising.price'),
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

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $advert;
    }

    /**
     * Gets quantity remaining map for passed advert ids
     *
     * @param $advertIDs
     * @return Collection
     */
    public function getAdvertQuantityMap($advertIDs): Collection
    {
        return Advert::whereIn('id', $advertIDs)
            ->get()
            ->mapWithKeys(function ($advert) {
                return [$advert->id => $advert->quantity_remaining];
            });
    }

    /**
     * Get all accepted adverts that have quantity_remaining with their respective priorities
     * [Advert => Priority]
     *
     * @return Collection
     */
    public function getAdvertSchedulingPriorityMap(): Collection
    {
        $adverts = Advert::status('accepted')->hasRemaining()->get();

        return $adverts->mapWithKeys(function ($advert) {
            return [$advert->id => $this->calculatePriority($advert)];
        });
    }

    /**
     * Calculates an adverts priority based on quantity remaining and when it is last seen, modified by weights from config
     *
     * @param Advert $advert
     * @return int
     */
    private function calculatePriority(Advert $advert): int
    {
        return $advert->quantity_remaining * config('settings.advertising.weight_remaining')
            + Carbon::parse($advert->last_scheduled)->diffInDays(now()) * config('settings.advertising.weight_last_scheduled');
    }

    /**
     * Decrements quantity_remaining for adverts with passed ids
     * Updates last_scheduled for adverts with passed ids
     *
     * @param $advertIDs
     */
    public function massUpdateAdverts($advertIDs): void
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

    /**
     * Prepares an advert array|Collection for export, adds BOM, flattens the passed array and puts the proper headers
     *
     * @implements CanExport
     * @param array|Collection $data
     * @return array
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        $bom = "\xEF\xBB\xBF";

        $headers = [
            $bom . 'Naslov',
            'Kompanija',
            'Količina',
            'Preostala Količina',
            'Poslednje Zakazano',
            'Status',
            'Cena',
            'ID Korisnika',
        ];
        $output = [];
        foreach ($data as $advert) {
            $output[] = [
                $advert['title'] ?? '',
                $advert['company'] ?? '',
                $advert['quantity'] ?? '',
                $advert['quantity_remaining'] ?? '',
                $advert['last_scheduled'] ?? '',
                $advert['business_request']['status'] ?? '',
                $advert['business_request']['price'] ?? '',
                $advert['business_request']['user_id'] ?? '',
            ];
        }
        array_unshift($output, $headers);
        return $output;
    }
}
