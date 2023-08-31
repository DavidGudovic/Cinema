<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Resources\HallService;
use App\Services\Resources\UserService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HallService $hallService, UserService $userService)
    {
        return view('admin.report.index', [
            'halls' => $hallService->getHalls(),
            'managers' => $userService->getManagers(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(HallService $hallService)
    {
        return view('admin.report.create',[
            'halls' => $hallService->getHalls(auth()->user()->id),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
}
