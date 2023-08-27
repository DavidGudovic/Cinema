<?php

namespace App\Services\Resources;

use App\Models\BusinessRequest;
use App\Models\Reclamation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class ReclamationService
{

    /**
     * @param string $status
     * @param string $type
     * @param int $quantity
     * @return LengthAwarePaginator
     * Returns a paginated, optionally filtered/sorted list of requests
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
     * @param int $request_id
     * @param $text
     * @return void
     * Stores a reclamation
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
     * @param int $reclamation_id
     * @return void
     * Soft deletes a reclamation
     */
    public function cancelReclamation(int $reclamation_id): void
    {
        $reclamation = Reclamation::findOrFail($reclamation_id);
        $reclamation->delete();
    }
}
