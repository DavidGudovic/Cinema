<?php
namespace App\Services;

use App\Models\User;
use App\Models\Advert;
use App\Models\Booking;
use App\Models\BusinessRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class RequestableService{


    /*
    * Get all reqeusts for a user with optional filters, paginated
    */
    public function getFilteredRequestsPaginated(?string $status = 'all', ?string $type = 'all', ?int $quantity = 1) : LengthAwarePaginator
    {
        return BusinessRequest::with('requestable')
        //->fromUser(auth()->user())
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

    public function getRequest(int $id) : BusinessRequest
    {
        return BusinessRequest::with('requestable')
        ->withTrashed()
        ->findOrFail($id);
    }
}
