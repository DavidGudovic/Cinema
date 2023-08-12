<?php
namespace App\Services;

use App\Models\Advert;
use App\Models\BusinessRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class ReclamationService{

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
