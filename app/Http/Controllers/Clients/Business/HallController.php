<?php

namespace App\Http\Controllers\Clients\Business;

use App\Http\Controllers\Controller;
use App\Services\Resources\HallService;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HallService $hallService)
    {
        return view('resources.halls.index', [
            'halls' => $hallService->getHalls(),
        ]);
    }

}
