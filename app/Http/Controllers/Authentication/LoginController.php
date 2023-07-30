<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
/*
* This controller is responsible for handling login requests.
*/
class LoginController extends Controller
{
    /*
    * Show the login form.
    */
    public function create()
    {
        return view('authentication.login');
    }

    /*
    * Handle an incoming authentication request.
    */
    public function store(LoginRequest $request)
    {
        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('status', 'Uneli ste pogrešne podatke.');
        }

        if (!auth()->user()->verified) {
            auth()->logout();
            return back()->with('status', 'Morate potvrđivati svoj nalog. Proverite svoj email.');
        }

        return redirect()->route('/');
    }

    /*
    * Log the user out of the application.
    */
    public function destroy()
    {
        auth()->logout();
        return redirect()->route('/');
    }
}
