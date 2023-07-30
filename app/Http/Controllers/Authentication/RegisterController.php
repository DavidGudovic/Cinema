<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('verify.show', $user->id, $user->email);
    }

}
