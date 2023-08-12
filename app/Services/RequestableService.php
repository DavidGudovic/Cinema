<?php
namespace App\Services;

use App\Models\Advert;
use App\Models\BusinessRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RequestableService{

    /*
    * Get all reqeusts for a user with optional filters, paginated
    */
    public function getFilteredRequestsPaginated(?string $status = 'all', ?string $type = 'all', ?int $quantity = 1) : LengthAwarePaginator
    {
        return BusinessRequest::with('requestable')
        ->fromUser(auth()->user()->id)
        ->filterByStatus($status)
        ->filterByType($type)
        ->orderBy('created_at', 'desc')
        ->paginate($quantity);
    }

    /*
    * Cancel request
    */
    public function cancelRequest(BusinessRequest $request) : void
    {
        $request->delete();
    }

    /*
     Returns a request with its requestable model
    */
    public function getRequest(int $id) : BusinessRequest
    {
        return BusinessRequest::with(['requestable' => function (MorphTo $query) {
            $query->morphWith([
                Advert::class => ['screenings.tickets'],
            ]);
        }])
        ->withTrashed()
        ->findOrFail($id);
    }

}
