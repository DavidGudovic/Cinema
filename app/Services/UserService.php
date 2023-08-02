<?php
namespace App\Services;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Access\AuthorizationException;

/*
* Service for App\Models\User related operations
*/
class UserService{

    /*
    * Create a new user instance after a valid registration.
    */
    public function create($validated) : User{
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);
        return $user;
    }

    /*
    * Send verification email to user.
    */
    public function sendVerificationEmail($id, $email) : void{
        Mail::to($email)->send(new VerifyEmail($id, $email));
    }

    /*
    * Verify user email.
    * Checks signature hash against hash of email in db, if true, sets email_verified_at to now. if false throws AuthorizationException.
    */
    public function verifyEmail($id, $hash) : void{
        $user = User::find($id);

        if (! $user || ! hash_equals((string) $hash, sha1($user->email))) {
            throw new AuthorizationException;
        }

        $user->email_verified_at = now();
        $user->save();
        event(new Verified($user));
    }
    /*
    Deletes a user from database by id
    */
    public function deleteUser(int $userID) : void
    {
        User::destroy($userID);
        auth()->logout();
    }
    /*
    Assigns new data to the database for the currently authenticated user.
    */
    public function updateUser(array $newData) : void
    {
        $user = User::find(auth()->user()->id);
        $user->update([
            'username' => $newData['username'],
            'email' => $newData['email'],
            'name' => $newData['name'],
            'password' => Hash::make($newData['new_password']),
        ]);
    }
}
