<?php
namespace App\Services;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

/*
* Service for App\Models\User related operations
*/
class UserService{

        /*
        * Create a new user instance after a valid registration.
        */
        public function create($validated){
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
        public function sendVerificationEmail($id, $email){
            Mail::to($email)->send(new VerifyEmail($id, $email));
        }
}
