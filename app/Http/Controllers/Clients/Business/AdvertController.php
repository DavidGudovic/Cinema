<?php

namespace App\Http\Controllers\Clients\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\Advert\CreateRequest;
use App\Services\Resources\AdvertService;

class AdvertController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('business.advert.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, AdvertService $advertService)
    {
        try {
            $advertService->tryCreateAdvert($request['text'], $request['quantity'], $request['title'], $request['company'], $request['advert_url']);
        } catch (\Exception $e) {}
        return redirect()->route('adverts.create')->with('success', 'Advert created successfully');
    }
}
