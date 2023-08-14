<?php

namespace App\Http\Controllers\Clients\Business;

use App\Models\Advert;
use Illuminate\Http\Request;
use App\Services\AdvertService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertRequest;

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
    public function store(AdvertRequest $request, AdvertService $advertService)
    {
        try {
            $advertService->tryCreateAdvert($request['text'], $request['quantity'], $request['title'], $request['company'], $request['advert_url']);
        } catch (\Exception $e) {
        }
        return redirect()->route('adverts.create')->with('success', 'Advert created successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert)
    {
        //
    }
}
