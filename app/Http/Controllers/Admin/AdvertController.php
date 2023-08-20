<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    public function index()
    {
        return view('admin.advert.index');
    }

    public function edit(Advert $advert)
    {
    }

    public function update(Request $request, Advert $advert)
    {
    }
}
