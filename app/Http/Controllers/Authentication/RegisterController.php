<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Resources\UserService;

class RegisterController extends Controller
{
    /*
    * Show the registration form.
    */
    public function create()
    {
        return view('authentication.register');
    }

    /*
    * Handle an incoming registration request.
    */
    public function store(RegisterRequest $request, UserService $userService)
    {
        $user = $userService->create($request->validated());
        return redirect()->route('verify.show', [$user->id, $user->email]);
    }

}
