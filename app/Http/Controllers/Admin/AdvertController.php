<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Advert\UpdateRequest;
use App\Models\Advert;
use App\Services\AdvertService;
use App\Services\RequestableService;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    public function index()
    {
        return view('admin.advert.index');
    }

    public function edit(Advert $advert, Request $request)
    {
        return view('admin.advert.edit',
            [
                'advert' => $advert,
                'action' => $request['action'] ?? 'ACCEPT',
            ]);
    }

    public function update(Advert $advert, UpdateRequest $request, RequestableService $requestableService, AdvertService $advertService)
    {
        $requestableService->changeRequestStatus(
            $advert->businessRequest,
            $request['action'] == 'ACCEPT' ? Status::ACCEPTED : Status::REJECTED,
            $request['response'],
        );
        return redirect()->route('adverts.index');
    }
}
