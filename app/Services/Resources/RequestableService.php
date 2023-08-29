<?php

namespace App\Services\Resources;

use App\Enums\Status;
use App\Mail\Request\AcceptEmail;
use App\Mail\Request\RejectEmail;
use App\Models\Advert;
use App\Models\BusinessRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Mail;

class RequestableService
{
    /**
     * Maps the sort_by parameter to a column and a type (direct or relation)
     * [type => direct|relation, column => column_name]
     * Eloquent doesn't support sorting polymorphic relationships out of the box
     * Used for sortPolymorphic scope
     *
     * @param string $sort_by
     * @return string[]
     */
    public function resolveSortByParameter(string $sort_by): array
    {
        return match ($sort_by) { //Could've been done with exploding a string on '.' but this is more readable imo
            'businessRequest.price' => ['type' => 'relation', 'relation' => 'business_requests', 'column' => 'price'],
            'businessRequest.status' => ['type' => 'relation', 'relation' => 'business_requests', 'column' => 'status'],
            'businessRequest.user_id' => ['type' => 'relation', 'relation' => 'business_requests', 'column' => 'user_id'],
            'businessRequest.created_at' => ['type' => 'relation', 'relation' => 'business_requests', 'column' => 'created_at'],
            'hall.name' => ['type' => 'relation', 'relation' => 'halls', 'column' => 'name'],
            default => ['type' => 'direct', 'relation' => 'none', 'column' => $sort_by],
        };
    }

    /**
     * Returns a paginated, filtered list of requests
     * All parameters are optional, if none are set, all requests are returned, paginated by $quantity, default 1
     *
     * @param string|null $status
     * @param string|null $type
     * @param int|null $quantity
     * @return LengthAwarePaginator
     */
    public function getFilteredRequestsPaginated(?string $status = 'all', ?string $type = 'all', ?int $quantity = 1): LengthAwarePaginator
    {
        return BusinessRequest::with('requestable')
            ->fromUser(auth()->user()->id)
            ->filterByStatus($status)
            ->filterByType($type)
            ->orderBy('created_at', 'desc')
            ->paginate($quantity);
    }

    /**
     * Cancels a request
     *
     * @param BusinessRequest $request
     * @return void
     */
    public function cancelRequest(BusinessRequest $request): void
    {
        $request->delete();
    }

    /**
     * Returns a request by id, eager loads polymorphic relationship
     *
     * @param int $id
     * @return BusinessRequest
     */
    public function getRequest(int $id): BusinessRequest
    {
        return BusinessRequest::with(['requestable' => function (MorphTo $query) {
            $query->morphWith([
                Advert::class => ['screenings.tickets'],
            ]);
        }])
            ->withTrashed()
            ->findOrFail($id);
    }

    /**
     * Changes the status of a request and notifies the owner
     *
     * @param BusinessRequest $request
     * @param Status $status
     * @param string $response
     * @return void
     */
    public function changeRequestStatus(BusinessRequest $request, Status $status, string $response): void
    {
        $request->update(['status' => $status, 'comment' => $response]);
        $this->notifyOwner($request, $status);
    }

    /**
     * Notifies the owner of a request with an email
     *
     * @param BusinessRequest $request
     * @param Status $status
     * @return void
     */
    public function notifyOwner(BusinessRequest $request, Status $status): void
    {
        Mail::to($request->user->email)->send(
            $status == Status::ACCEPTED
                ? new AcceptEmail($request)
                : new RejectEmail($request)
        );
    }

}
