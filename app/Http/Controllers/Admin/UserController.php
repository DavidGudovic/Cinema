<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use App\Services\Resources\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', [
            'user' => $user,
            'roles' => collect(Roles::cases())->mapWithKeys(fn ($role) => [$role->value => $role->ToSrLatinString()]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user, UserService $userService)
    {
        $userService->updateUserByAdmin($request->all(), $user);
        return redirect()->back()->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserService $userService)
    {
        $userService->deleteUser($user->id);
        return redirect()->back()->with('message', 'Korisnik ' . $user->name . ' je uspešno obrisan');
    }
}
