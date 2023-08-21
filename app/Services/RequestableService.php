<?php

namespace App\Services;

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
     */
    public function resolveSortByParameter(string $sort_by): array
    {
        return match ($sort_by) {
            'businessRequest.price' => ['type' => 'relation', 'relation' => 'business_requests',  'column' => 'price'],
            'businessRequest.status' => ['type' => 'relation', 'relation' => 'business_requests',  'column' => 'status'],
            'businessRequest.user_id' => ['type' => 'relation', 'relation' => 'business_requests',  'column' => 'user_id'],
            'businessRequest.created_at' => ['type' => 'relation', 'relation' => 'business_requests',  'column' => 'created_at'],
            'hall.name' => ['type' => 'relation', 'relation' => 'hall',  'column' => 'name'],
            default => ['type' => 'direct','relation' => 'none', 'column' => $sort_by],
        };
    }

    /*
    * Get all requests for a user with optional filters, paginated
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

    /*
    * Cancel request
    */
    public function cancelRequest(BusinessRequest $request): void
    {
        $request->delete();
    }

    /*
     Returns a request with its requestable model
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
     */
    public function changeRequestStatus(BusinessRequest $request, Status $status, string $response): void
    {
        $request->update(['status' => $status, 'comment' => $response]);
        $this->notifyOwner($request, $status);
    }

    /**
     * Emails the owner of the request with the status of the request
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
