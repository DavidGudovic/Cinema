<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Authentication
Route::resource('register', RegisterController::class, ['only' => ['create', 'store']]);
Route::resource('login', LoginController::class, ['only' => ['create', 'store', 'destroy']]);

Route::name('verify.')->controller(VerificationController::class)->group(function (){
    Route::get('/verify')->name('show');
    Route::get('/verify/{id}/{email}', 'update')->name('update');
});
