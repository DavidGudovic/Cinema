<?php

namespace App\Services\Resources;

use App\Models\BusinessRequest;
use App\Models\Reclamation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class ReclamationService
{

    /**
     * Returns a paginated, optionally filtered/sorted list of requests
     * All parameters are optional, if none are set, all requests are returned, paginated by $quantity, default 1
     *
     * @param string $status
     * @param string $type
     * @param int $quantity
     * @return LengthAwarePaginator
     */
    public function getFilteredReclamationsPaginated(string $status = 'all', string $type = 'all', int $quantity = 1): LengthAwarePaginator
    {
        return Reclamation::fromUser(auth()->user()->id)
            ->filterByStatus($status)
            ->filterByType($type)
            ->orderBy('created_at', 'desc')
            ->paginate($quantity);
    }

    /**
     * Stores a reclamation
     *
     * @param int $request_id
     * @param $text
     * @return void
     */
    public function storeReclamation(int $request_id, $text): void
    {
        $request = BusinessRequest::findOrFail($request_id);
        $request->reclamation()->create([
            'text' => $text,
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Soft deletes a reclamation
     *
     * @param int $reclamation_id
     * @return void
     */
    public function cancelReclamation(int $reclamation_id): void
    {
        $reclamation = Reclamation::findOrFail($reclamation_id);
        $reclamation->delete();
    }
}
