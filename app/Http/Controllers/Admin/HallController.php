<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Services\Resources\HallService;
use App\Services\Resources\UserService;
use Illuminate\Http\Request;

class HallController extends Controller
{
    /**
     * Display a listing of halls.
     */
    public function index(HallService $hallService, UserService $userService)
    {
        return view('admin.hall.index', [
            'halls' => $hallService->getHalls(),
            'managers' => $userService->getManagers(),
        ]);
    }

    /**
     * Update the specified hall in storage.
     */
    public function update(Request $request, Hall $hall)
    {
        //
    }

}
