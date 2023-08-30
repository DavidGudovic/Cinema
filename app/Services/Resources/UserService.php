<?php

namespace App\Services\Resources;

use App\Interfaces\CanExport;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService implements CanExport
{

    /**
     * Create a new user instance after a valid registration.
     *
     * @param $validated
     * @return User
     */
    public function create($validated): User
    {
        return User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);
    }

    /**
     * Send verification email to user.
     *
     * @param int $id
     * @param string $email
     * @return void
     */
    public function sendVerificationEmail(int $id, string $email): void
    {
        Mail::to($email)->send(new VerifyEmail($id, $email));
    }

    /**
     * Verify user email.
     * Checks signature hash against hash of email in db, if true, sets email_verified_at to now. if false throws AuthorizationException
     *
     * @param int $id
     * @param $hash
     * @return void.
     */
    public function verifyEmail(int $id, $hash): void
    {
        $user = User::find($id);

        if (!$user || !hash_equals((string)$hash, sha1($user->email))) {
            throw new AuthorizationException;
        }

        $user->email_verified_at = now();
        $user->save();
    }

    /**
     * Deletes a user from database by id
     *
     * @param int $userID
     * @return void
     */
    public function deleteUser(int $userID): void
    {
        User::destroy($userID);
        auth()->logout();
    }

    /**
     * Assigns new data to the database for the currently authenticated user
     *
     * @param array $newData
     * @return void.
     */
    public function updateUser(array $newData): void
    {
        $user = User::find(auth()->user()->id);
        $user->update([
            'username' => $newData['username'],
            'email' => $newData['email'],
            'name' => $newData['name'],
            'password' => Hash::make($newData['new_password']),
        ]);
    }

    /**
     * Returns a paginated list of users with optional search query and sorting
     *
     * @return LengthAwarePaginator
     */
    public function getFilteredUsersPaginated() : LengthAwarePaginator
    {
        return User::paginate(10);
    }

    /**
     * Prepares a user collection for export, adds BOM, flattens array, adds headers
     *
     * @implements CanExport
     * @param array|Collection $data
     * @return array
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        // TODO: Implement sanitizeForExport() method.
    }
}
