<?php

namespace App\Http\Controllers\Clients\Business;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Resources\RequestableService;

class RequestableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user, RequestableService $requestableService)
    {
        return view('business.requestable.index', [
            'user' => $user,
            'requestables' => $requestableService->getFilteredRequestsPaginated()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
