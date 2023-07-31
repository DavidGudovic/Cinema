<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\UserController;
use App\Http\Controllers\Clients\TicketController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Registration
Route::resource('register', RegisterController::class, ['only' => ['create', 'store']]);

// Login
Route::resource('login', LoginController::class, ['only' => 'store']);
Route::get('create/{id?}/{email?}', [LoginController::class, 'create'])->name('login.create');
Route::get('logout', [LoginController::class, 'destroy'])->name('logout');

// Verification
Route::name('verify.')->controller(VerificationController::class)->group(function (){
    Route::get('/show/{id}/{email}', 'show')->name('show');
    Route::get('/update/{id}/{email}', 'update')->name('update');
});

// User routes authenticated and private to the user
Route::middleware('auth', 'private')->group(function () {
  Route::resource('user', UserController::class)->only(['show', 'update', 'destroy']);
  Route::get('user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');
  Route::resource('user.tickets', TicketController::class);
});
