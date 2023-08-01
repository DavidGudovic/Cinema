<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
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
    public function create(?int $id = null, ?string $email = null)
    {
        return view('authentication.login', [
            'id' => $id ?? 0,
            'email' => $email ?? '',
        ]);;
    }

    /*
    * Handle an incoming authentication request.
    */
    public function store(LoginRequest $request)
    {
        /*
        * Attempt to authenticate the request.
        */
        if (!auth()->attempt($request->only('username', 'password'), $request->remember)) {
            return back()->with(['status' => 'error', 'status_msg' => 'Uneli ste pogrešne podatke']);
        }

        /*
        * Check if the user has verified their email.
        */
        if (auth()->user()->email_verified_at === null) {
            $id = auth()->user()->id;
            $email = auth()->user()->email;
            auth()->logout();
            return back()
            ->with(['status' => 'error', 'status_msg' => 'Morate potvrditi svoj nalog. Proverite email.',
            'verification_error' => true,
            'id' => $id, 'email' => $email]);
        }
        return redirect()->intended('home');
    }

    /*
    * Log the user out of the application.
    */
    public function destroy(User $user)
    {
        auth()->logout();
        return redirect()->route('home');
    }
}
