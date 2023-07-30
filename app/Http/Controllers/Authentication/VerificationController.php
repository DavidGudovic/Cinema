<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    /*
    * Show the email verification form.
    */
    public function show()
    {
        return view('authentication.verify-email');
    }

    /*
    * Mark the authenticated user's email address as verified.
    */
    public function update(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (! $user || ! hash_equals((string) $hash, sha1($user->email))) {
            throw new AuthorizationException;
        }

        $user->email_verified_at = now();
        $user->save();
        event(new Verified($user));

        return redirect()->route('home');
    }

}
