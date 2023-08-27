<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use App\Services\Resources\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/*
* Controller for App\Models\User related operations
*/
class UserController extends Controller
{

    /*
    Displays the form for deleting the account
    */
    public function delete(User $user)
    {
        return view('users.delete');
    }

    /**
    * Display the users information.
    */
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    /**
    *  Update users information if password is correct
    */
    public function update(UpdateRequest $request,UserService $userService, User $user)
    {
        if(!Hash::check($request->input('current_password'), $user->password)){
            return back()->withErrors(['current_password'=>'Uneli ste pogrešnu šifru']);
        }
        $userService->updateUser($request->validated());
        return back()->with(['status'=> 'success', 'status_msg' => 'Uspešno ste izmenili podatke!']);
    }


    /**
    *  Delete users account from database if password is correct
    */
    public function destroy(User $user, UserService $userService,Request $request)
    {
        if(!Hash::check($request->input('password'), $user->password)){
            return back()->withErrors(['password'=>'Uneli ste pogrešnu šifru']);
        }

        $userService->deleteUser($user->id);
        return redirect()->route('home');
    }
}
