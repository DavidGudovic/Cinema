<?php

namespace App\Http\Controllers\Clients\Business;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use Illuminate\Http\Request;
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
    public function store(AdvertRequest $request)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert)
    {
        //
    }
}
