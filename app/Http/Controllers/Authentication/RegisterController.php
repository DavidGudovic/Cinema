<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\Roles;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;

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
    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        Mail::to($user->email)->send(new VerifyEmail($user->id, $user->email));
        return redirect()->route('verify.show');
    }

}
