<?php

namespace App\Http\Controllers\Clients\Business;

use App\Models\User;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReclamationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        return view('business.reclamation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reclamation $reclamation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reclamation $reclamation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reclamation $reclamation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reclamation $reclamation)
    {
        //
    }
}
