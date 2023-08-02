<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Resources\ScreeningController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Clients\UserController;
use App\Http\Controllers\Clients\TicketController;
use App\Http\Controllers\Resources\MovieController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\VerificationController;
use App\Http\Controllers\Clients\Business\ReclamationController;
use App\Http\Controllers\Clients\Business\RequestableController;

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


/*
* Public routes - Anyone can access these routes
*/
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('movies/{genre?}', [MovieController::class, 'index'])->name('movies.index');
/*
* Authentication routes - Only guests can access these routes
*/
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
/*
* User routes - Only authenticated users can access these routes
*/
Route::middleware('auth')->group(function () {
    /*
    * Private routes - User can only access the route that's specific to his id (user/{user})
    * i.e user id 1 can only access user/1, user id 2 can only access user/2 etc.
    */
    Route::middleware('private')->group(function () {
        Route::get('logout/{user}', [LoginController::class, 'destroy'])->name('logout');
        Route::get('user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');
        Route::resource('user', UserController::class)->only(['show', 'update', 'destroy']);
        /*
        * Only private clients can have/see tickets
        */
        Route::middleware('role:CLIENT')->group(function(){
            Route::resource('user.tickets', TicketController::class)->only('index', 'show');
        });

        /* Only Business clients can have/see requests and reclamations */
        Route::middleware('role:BUSINESS_CLIENT')->group(function(){
            Route::resource('user.requests', RequestableController::class)->only(['index', 'show', 'update']);
            Route::resource('user.reclamations', ReclamationController::class)->only(['index', 'show', 'update']);
        });
    });
     /*
     * Public routes - User can access any route that's not specific to his id
     */
    Route::resource('movie.screenings', ScreeningController::class)->only(['index', 'show']);
});



