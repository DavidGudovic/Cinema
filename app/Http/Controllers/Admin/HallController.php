<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Services\Resources\HallService;
use Illuminate\Http\Request;

class HallController extends Controller
{
    /**
     * Display a listing of halls.
     */
    public function index(HallService $hallService)
    {
        return view('admin.hall.index', [
            'halls' => $hallService->getHalls(),
        ]);s
    }

    /**
     * Update the specified hall in storage.
     */
    public function update(Request $request, Hall $hall)
    {
        //
    }

}
