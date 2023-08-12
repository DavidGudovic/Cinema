<?php
namespace App\Services;

use App\Models\Advert;
use App\Models\BusinessRequest;
use App\Models\Reclamation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class ReclamationService{

    /*
    * Get all reqeusts for a user with optional filters, paginated
    */
    public function getFilteredReclamationsPaginated(?string $status = 'all', ?string $type = 'all', ?int $quantity = 1) : LengthAwarePaginator
    {
        return Reclamation::fromUser(auth()->user()->id)
        ->filterByStatus($status)
        ->filterByType($type)
        ->orderBy('created_at', 'desc')
        ->paginate($quantity);
    }

    /*
    * Stores a reclamation for a request
    */
    public function storeReclamation(int $request_id, $text) : void
    {
        $request = BusinessRequest::findOrFail($request_id);
        $request->reclamation()->create([
            'text' => $text,
            'user_id' => auth()->user()->id,
        ]);
    }
}
