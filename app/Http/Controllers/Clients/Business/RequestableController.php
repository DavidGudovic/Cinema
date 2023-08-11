<?php

namespace App\Http\Controllers\Clients\Business;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RequestableService;

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
