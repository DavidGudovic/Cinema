<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Requestable\UpdateRequest;
use App\Models\Reclamation;
use App\Services\Resources\ReclamationService;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.reclamation.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Reclamation $reclamation)
    {
        return view('admin.reclamation.edit',
        [
            'reclamation' => $reclamation,
            'action' => $request['action'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Reclamation $reclamation, UpdateRequest $request, ReclamationService $reclamationService)
    {
        $reclamationService->changeReclamationStatus(
            $reclamation,
            $request['action'] == 'ACCEPT' ? Status::ACCEPTED : Status::REJECTED,
            $request['response'],
        );
        return redirect()->route('reclamations.index');
    }
}
