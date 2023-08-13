<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Clients\UserController;
use App\Http\Controllers\Clients\TicketController;
use App\Http\Controllers\Resources\MovieController;
use App\Http\Controllers\Resources\ScreeningController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\VerificationController;
use App\Http\Controllers\Clients\Business\HallController;
use App\Http\Controllers\Clients\Business\ReclamationController;
use App\Http\Controllers\Clients\Business\BookingController;
use App\Http\Controllers\Clients\Business\RequestableController;
use App\Http\Controllers\Clients\Business\AdvertController;


/* * Public routes - Anyone can access these routes */

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('movies/{genre?}', [MovieController::class, 'index'])->name('movies.index');
Route::resource('movie.screenings', ScreeningController::class)->only(['index']);

/* * Authentication routes - Only guests can access these routes */

Route::middleware('guest')->group(function () {
    // Registration
    Route::resource('register', RegisterController::class, ['only' => ['create', 'store']]);
    // Login
    Route::resource('login', LoginController::class, ['only' => 'store']);
    Route::get('login/{id?}/{email?}', [LoginController::class, 'create'])->name('login.create');
    // Verification
    Route::name('verify.')->controller(VerificationController::class)->group(function (){
        Route::get('/show/{id}/{email}', 'show')->name('show');
        Route::get('/update/{id}/{email}', 'update')->name('update');
    });
});


/*  Authenticated routes - Only authenticated users can access these routes */

Route::middleware('auth')->group(function () {

    /**************************************  Private routes ************************************************/

    /* Sensitive data, prevent users from accessing other users data, tickets, bookings, advertising stats etc. */

    Route::middleware('private')->group(function () {

        Route::get('logout/{user}', [LoginController::class, 'destroy'])->name('logout');
        Route::get('user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');
        Route::resource('user', UserController::class)->only(['show', 'update', 'destroy']);

        Route::middleware('role:CLIENT')->group(function(){
            Route::resource('user.tickets', TicketController::class)->only('index', 'show');
            Route::get('user/{user}/tickets/{ticket}/print', [TicketController::class, 'print'])->name('user.tickets.print');
        });

        Route::middleware('role:BUSINESS_CLIENT')->group(function(){
            Route::resource('user.requests', RequestableController::class)->only(['index', 'show', 'destroy' ]);
            Route::resource('user.adverts', AdvertController::class)->only(['destroy']);
            Route::resource('user.reclamations', ReclamationController::class)->only(['index','show', 'update']);
        });

        Route::middleware('role:MANAGER')->group(function(){
            // TODO: Add routes
        });

        Route::middleware('role:ADMIN')->group(function(){
            // TODO: Add routes
        });
    });
    /****************************************** End private routes ********************************************/

    /*************************************** Public authenticated routes **************************************/

    /* All endpoints are public to every user with the correct role. */

    Route::middleware('role:CLIENT')->group(function(){
        Route::resource('movie.screenings', ScreeningController::class)->only(['show'])->middleware(['screening']);
    });

    Route::middleware('role:BUSINESS_CLIENT')->group(function(){
        Route::resource('adverts', AdvertController::class)->only(['create', 'store']);
        Route::resource('halls', HallController::class)->only(['index']);
        Route::resource('halls.booking', BookingController::class)->only(['create','store']);
    });

    Route::middleware('role:MANAGER')->group(function(){
        // TODO: Add routes
    });

    Route::middleware('role:ADMIN')->group(function(){
        // TODO: Add routes
    });
    /*************************************** End public authenticated routes ************************************/

});



