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
