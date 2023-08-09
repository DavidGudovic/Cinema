<?php

namespace App\Http\Controllers\Clients\Business;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\HallService;
use App\Http\Controllers\Controller;

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
