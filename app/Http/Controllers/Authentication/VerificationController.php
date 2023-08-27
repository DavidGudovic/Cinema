<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Services\Resources\UserService;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    * Show the email verification form.
    */
    public function show($id, $email, UserService $userService)
    {
        $userService->sendVerificationEmail($id, $email);
        return view('authentication.verification', [
            'id' => $id,
            'email' => $email,
        ]);
    }

    /*
    * Mark the authenticated user's email address as verified.
    */
    public function update(Request $request, $id, $hash, UserService $userService)
    {
        $userService->verifyEmail($id, $hash);
        return redirect()->route('login.create')
        ->with([
            'status' => 'success',
            'status_msg' => 'Vaš email je verifikovan. Ulogujte se.'
        ]);
    }

}
