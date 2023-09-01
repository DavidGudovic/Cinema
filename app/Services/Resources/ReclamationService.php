<?php

namespace App\Services\Resources;

use App\Enums\Status;
use App\Interfaces\CanExport;
use App\Mail\Reclamation\AcceptEmail;
use App\Models\BusinessRequest;
use App\Models\Reclamation;
use App\Traits\Notifications;
use App\Traits\WithRelationalSort;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class ReclamationService implements CanExport
{
    use WithRelationalSort, Notifications;

    /**
     * Returns a paginated, optionally filtered/sorted list of requests
     * All parameters are optional, if none are set, all requests are returned, paginated by $quantity, default 1
     *
     * @param string $status
     * @param string $type
     * @param int|null $user_id
     * @param string $search_query
     * @param bool $do_sort
     * @param string $sort_by
     * @param string $sort_direction
     * @param int $quantity
     * @return LengthAwarePaginator|Collection
     */
    public function getFilteredReclamationsPaginated(string $status = 'all', string $type = 'all',?int $user_id = null, string $search_query = '', bool $do_sort = true, string $sort_by = 'created_at', string $sort_direction = 'ASC', int $quantity = 1): LengthAwarePaginator|Collection
    {
        $sort_params = $this->resolveSortByParameter($sort_by);
        return Reclamation::fromUser($user_id ?? auth()->user()->id)
            ->filterByStatus($status)
            ->filterByType($type)
            ->search($search_query)
            ->sortPolymorphic($do_sort, $sort_params['type'], $sort_params['relation'], $sort_params['column'], $sort_direction)
            ->paginateOptional($quantity);
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

    /**
     * Prepares a reclamation list for export, adds bom, flattens array, adds headers
     *
     *
     * @param array|Collection $data
     * @return array
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        $bom = "\xEF\xBB\xBF";

        $headers = [
            $bom.'ID',
            'Datum',
            'Korisnik',
            'Tekst',
            'Status',
            'Komentar',
            'ZahtevID',
            'Tip',
        ];

        $output = [];
        foreach ($data as $reclamation) {
            $output[] = [
                $reclamation['id'] ?? '',
                $reclamation['created_at'] ?? '',
                $reclamation['user_id'] ?? '',
                $reclamation['text'] ?? '',
                $reclamation['status'] ?? '',
                $reclamation['comment'] ?? '',
                $reclamation['business_request']['id'] ?? '',
                $reclamation['business_request']['requestable_type'] == 'App\Models\Booking' ? 'Rentiranje' : 'Oglas',
            ];
        }
        array_unshift($output, $headers);
        return $output;

    }

    /**
     * Changes the status of a reclamation, notifies the owner
     *
     * @param Reclamation $reclamation
     * @param Status $status
     * @param string $response
     * @return void
     */
    public function changeReclamationStatus(Reclamation $reclamation, Status $status,string $response): void
    {
        $reclamation->update([
            'status' => $status,
            'comment' => $response,
        ]);
        $this->notifyOwner($reclamation, $status, new AcceptEmail($reclamation), new AcceptEmail($reclamation));
    }
}
